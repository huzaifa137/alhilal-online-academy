<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class SetLocale
{
    /**
     * Resolve the active language for this request:
     *   1. session (set when the user clicks the switcher)
     *   2. long-lived cookie (survives logout / session expiry)
     *   3. default language (English)
     */
    public function handle(Request $request, Closure $next)
    {
        $supported = config('languages.supported', []);
        $default   = config('languages.default', 'en');

        $locale = $request->hasSession() ? $request->session()->get('locale') : null;

        if (!$locale || !isset($supported[$locale])) {
            $locale = $request->cookie(config('languages.cookie', 'alhilal_locale'));
        }

        if (!$locale || !is_string($locale) || !isset($supported[$locale])) {
            $locale = $default;
        }

        // Keep session in sync (e.g. session was flushed on logout but cookie survived)
        if ($request->hasSession() && $request->session()->get('locale') !== $locale) {
            $request->session()->put('locale', $locale);
        }

        App::setLocale($locale);

        try {
            Carbon::setLocale($locale);
        } catch (\Throwable $e) {
            // ignore – Carbon falls back to English
        }

        View::share('currentLocale', $locale);
        View::share('currentDir', $supported[$locale]['dir'] ?? 'ltr');

        return $next($request);
    }
}
