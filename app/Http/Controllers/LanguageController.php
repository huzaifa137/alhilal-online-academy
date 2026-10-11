<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Switch the site language, remember it (session + long-lived cookie)
     * and send the visitor back to the page they were on.
     */
    public function switch(Request $request, string $locale)
    {
        $supported = config('languages.supported', []);

        if (!array_key_exists($locale, $supported)) {
            abort(404);
        }

        $request->session()->put('locale', $locale);

        $cookie = cookie(
            config('languages.cookie', 'alhilal_locale'),
            $locale,
            (int) config('languages.cookie_minutes', 525600)
        );

        return redirect()->to($this->safeReturnUrl($request))->withCookie($cookie);
    }

    /**
     * Only ever redirect back to this same site, and never back to a
     * language-switch URL (avoids loops / open redirects).
     */
    protected function safeReturnUrl(Request $request): string
    {
        $fallback = url('/');
        $previous = url()->previous($fallback);

        $host = parse_url($previous, PHP_URL_HOST);
        $path = (string) parse_url($previous, PHP_URL_PATH);

        if ($host !== null && $host !== $request->getHost()) {
            return $fallback;
        }

        if (strpos($path, '/language/') !== false) {
            return $fallback;
        }

        return $previous;
    }
}
