<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;

/**
 * Thin wrapper around mPDF so report cards, certificates and any other PDF
 * can render real Arabic (letter joining + right-to-left ordering).
 *
 * mPDF does the Arabic shaping itself. Do NOT pass text through
 * ar-php utf8Glyphs() / strrev() before it reaches this class, or it will be
 * shaped twice and come out broken again.
 *
 * Usage:
 *   return ArabicPdf::make(['orientation' => 'L'])
 *       ->view('certificates.pdf', $data)
 *       ->stream('certificate.pdf');
 */
class ArabicPdf
{
    protected Mpdf $mpdf;

    public function __construct(array $options = [])
    {
        // Large pages with many styled cells can hit PCRE's default limit.
        @ini_set('pcre.backtrack_limit', '5000000');

        $tempDir = storage_path('app/mpdf');
        if (! is_dir($tempDir)) {
            @mkdir($tempDir, 0775, true);
        }

        $fontDirs = (new ConfigVariables())->getDefaults()['fontDir'];
        $fontData = (new FontVariables())->getDefaults()['fontdata'];

        // Arabic fonts: Amiri already ships in public/assets/fonts (used by the old
        // dompdf templates). resources/fonts is also checked for overrides.
        foreach ([public_path('assets/fonts'), resource_path('fonts')] as $customDir) {
            if (! is_dir($customDir)) {
                continue;
            }

            $fontDirs[] = $customDir;

            if (! isset($fontData['amiri']) && is_file($customDir . '/Amiri-Regular.ttf')) {
                $fontData['amiri'] = [
                    'R'          => 'Amiri-Regular.ttf',
                    'B'          => is_file($customDir . '/Amiri-Bold.ttf') ? 'Amiri-Bold.ttf' : 'Amiri-Regular.ttf',
                    'useOTL'     => 0,
                ];
            }
        }

        // 'single_page' => true stops mPDF adding a blank 2nd page when the page is
        // built from absolutely-positioned layers (certificates).
        $singlePage = (bool) ($options['single_page'] ?? false);
        unset($options['single_page']);

        // 'background' => '/abs/path/image.png' paints one image over the whole page
        // behind the content (used for the certificate frame).
        $background = $options['background'] ?? null;
        unset($options['background']);

        $config = array_merge([
            'mode'              => 'utf-8',
            'format'            => 'A4',
            'orientation'       => 'P',
            'margin_left'       => 0,
            'margin_right'      => 0,
            'margin_top'        => 0,
            'margin_bottom'     => 0,
            'tempDir'           => $tempDir,
            'fontDir'           => $fontDirs,
            'fontdata'          => $fontData,
            'default_font'      => 'dejavusans',
            'default_font_size' => 10,
            // Detect Arabic runs automatically and switch to an Arabic font.
            'autoScriptToLang'  => true,
            'autoLangToFont'    => true,
            'useSubstitutions'  => true,
        ], $options);

        $this->mpdf = new Mpdf($config);
        $this->mpdf->autoArabic = true;

        if ($background && is_file($background)) {
            $this->mpdf->SetDefaultBodyCSS('background', "url('" . $background . "')");
            $this->mpdf->SetDefaultBodyCSS('background-image-resize', 6);
        }

        if ($singlePage) {
            $this->mpdf->SetAutoPageBreak(false);
        }
        $this->mpdf->SetDisplayMode('fullpage');
    }

    public static function make(array $options = []): self
    {
        return new self($options);
    }

    public function html(string $html): self
    {
        $this->mpdf->WriteHTML($html);

        return $this;
    }

    public function view(string $view, array $data = []): self
    {
        return $this->html(View::make($view, $data)->render());
    }

    public function mpdf(): Mpdf
    {
        return $this->mpdf;
    }

    /** Raw PDF bytes. */
    public function output(): string
    {
        return $this->mpdf->Output('', Destination::STRING_RETURN);
    }

    public function save(string $path): string
    {
        $dir = dirname($path);
        if (! is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        file_put_contents($path, $this->output());

        return $path;
    }

    /** Show in the browser (same behaviour as dompdf's ->stream()). */
    public function stream(string $filename = 'document.pdf'): Response
    {
        return $this->respond($filename, 'inline');
    }

    /** Force a download (same behaviour as dompdf's ->download()). */
    public function download(string $filename = 'document.pdf'): Response
    {
        return $this->respond($filename, 'attachment');
    }

    protected function respond(string $filename, string $disposition): Response
    {
        $safe = preg_replace('/[^A-Za-z0-9._-]+/', '_', $filename) ?: 'document.pdf';

        return response($this->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => $disposition . '; filename="' . $safe . '"',
        ]);
    }
}
