<?php

namespace App\Http\Middleware;

use App\Services\HtmlTranslator;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class TranslateResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            return $this->process($request, $response);
        } catch (\Throwable $e) {
            // Never break a page because of translation – serve it untouched.
            Log::warning('TranslateResponse skipped: ' . $e->getMessage());
            return $response;
        }
    }

    protected function process(Request $request, $response)
    {
        if (!($response instanceof \Illuminate\Http\Response)) {
            return $response; // redirects, JSON, downloads, streams, files...
        }

        $contentType = (string) $response->headers->get('Content-Type', 'text/html');
        if (stripos($contentType, 'text/html') === false) {
            return $response;
        }

        $html = $response->getContent();
        if (!is_string($html) || $html === '' || strpos($html, '<') === false) {
            return $response; // plain-text AJAX replies must stay untouched
        }

        $isDocument = stripos($html, '</body>') !== false || stripos($html, '<html') !== false;

        // Floating switcher safety-net for any full page that has no switcher yet.
        if ($isDocument && !$request->ajax() && strpos($html, 'data-lang-switcher') === false
            && !$request->is('language/*')) {
            $html = $this->injectFloatingSwitcher($html);
        }

        $locale  = App::getLocale();
        $default = config('languages.default', 'en');

        if ($locale !== $default) {
            $translator = HtmlTranslator::forLocale($locale);
            $html = $translator->translate($html);
        }

        $response->setContent($html);

        return $response;
    }

    protected function injectFloatingSwitcher(string $html): string
    {
        $switcher = view('partials.language-switcher', ['floating' => true])->render();

        $pos = strripos($html, '</body>');
        if ($pos === false) {
            return $html;
        }

        return substr($html, 0, $pos) . $switcher . substr($html, $pos);
    }
}
