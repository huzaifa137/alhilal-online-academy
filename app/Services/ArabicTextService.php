<?php

namespace App\Services;

use ArPHP\I18N\Arabic;

/**
 * DomPDF does not perform Arabic contextual letter-shaping (initial /
 * medial / final / isolated forms) or bidi reordering on its own — Arabic
 * text passed to it verbatim renders as disconnected, reversed letters.
 *
 * We fix that by pre-processing every Arabic string through Ar-PHP's
 * Glyphs engine (khaled.alshamaa/ar-php) before it reaches the Blade
 * view, which reshapes + reorders the text into the visual form dompdf
 * is able to draw correctly with a regular (non-shaping) Arabic font
 * such as Amiri or Tajawal.
 */
class ArabicTextService
{
    private static ?Arabic $engine = null;

    /**
     * Shape an Arabic (or mixed Arabic/Latin) string for correct rendering
     * inside a dompdf-generated PDF. Safe to call on empty/null strings.
     */
    public static function shape(?string $text): string
    {
        if ($text === null || trim($text) === '') {
            return (string) $text;
        }

        // If Ar-PHP hasn't been installed yet (composer update not run),
        // fail gracefully and just return the original text rather than
        // fatal-erroring the whole certificate.
        if (!class_exists(Arabic::class)) {
            return $text;
        }

        if (self::$engine === null) {
            self::$engine = new Arabic('Glyphs');
        }

        return self::$engine->utf8Glyphs($text);
    }

    /**
     * Arabic ordinal words for 1..12, used to build "السنة الأولى", etc.
     */
    private static function ordinalAr(int $n): string
    {
        $ordinals = [
            1 => 'الأولى', 2 => 'الثانية', 3 => 'الثالثة', 4 => 'الرابعة',
            5 => 'الخامسة', 6 => 'السادسة', 7 => 'السابعة', 8 => 'الثامنة',
            9 => 'التاسعة', 10 => 'العاشرة', 11 => 'الحادية عشرة', 12 => 'الثانية عشرة',
        ];

        return $ordinals[$n] ?? (string) $n;
    }

    /**
     * Best-effort Arabic translation of a level code (P1, I2, T3, ...)
     * used across Al-Hilal's Primary / Idaad / Thanawi sections. Falls
     * back to the English level name if the code isn't recognised.
     */
    public static function levelLabel(?string $code, ?string $englishName = null): string
    {
        if (!$code || !preg_match('/^([A-Za-z]+)\s*(\d+)$/', trim($code), $m)) {
            return $englishName ?? (string) $code;
        }

        $prefix = strtoupper($m[1]);
        $number = (int) $m[2];
        $ordinal = self::ordinalAr($number);

        return match ($prefix) {
            'P' => "السنة {$ordinal} - الابتدائية",
            'I' => "السنة {$ordinal} - الإعدادية",
            'T' => "السنة {$ordinal} - الثانوية",
            default => $englishName ?? (string) $code,
        };
    }

    /**
     * Best-effort Arabic translation of a section name (Primary / Idaad /
     * Thanawi). Falls back to the original name if unrecognised.
     */
    public static function sectionLabel(?string $sectionName): ?string
    {
        if (!$sectionName) {
            return null;
        }

        return match (true) {
            str_contains(strtolower($sectionName), 'primary') => 'المستوى الابتدائي',
            str_contains(strtolower($sectionName), 'idaad')   => 'المستوى الإعدادي',
            str_contains(strtolower($sectionName), 'thanawi') => 'المستوى الثانوي',
            default => $sectionName,
        };
    }
}
