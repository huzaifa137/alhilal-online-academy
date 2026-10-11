<?php

/*
|--------------------------------------------------------------------------
| Supported Site Languages
|--------------------------------------------------------------------------
|
| Used by the language switcher, the SetLocale middleware and the
| HtmlTranslator. To add a language later: add an entry here, then add
| resources/lang/<code>.json (plus resources/lang/<code>/*.php if wanted).
|
*/

return [

    // Language used when the visitor has not chosen one yet.
    'default' => env('DEFAULT_LOCALE', 'en'),

    // Name of the (long-lived) cookie that remembers the visitor's choice,
    // so it survives logout / session expiry / browser restarts.
    'cookie' => 'alhilal_locale',

    // Cookie lifetime in minutes (1 year).
    'cookie_minutes' => 60 * 24 * 365,

    'supported' => [
        'en' => [
            'name'   => 'English',
            'native' => 'English',
            'short'  => 'EN',
            'dir'    => 'ltr',
        ],
        'ar' => [
            'name'   => 'Arabic',
            'native' => 'العربية',
            'short'  => 'ع',
            'dir'    => 'rtl',
        ],
        'sw' => [
            'name'   => 'Swahili',
            'native' => 'Kiswahili',
            'short'  => 'SW',
            'dir'    => 'ltr',
        ],
    ],
];
