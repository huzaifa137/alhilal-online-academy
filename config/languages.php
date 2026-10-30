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
| The same codes are also used as the TEACHING LANGUAGE of lessons, study
| materials and quizzes (their `language` column). See App\Support\ContentLanguage.
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

    // When true (default) a student only sees / can open the lessons, study
    // materials and quizzes taught in the language they currently have
    // selected. Switching language therefore starts a fresh learning track.
    // Set CONTENT_LANGUAGE_LOCK=false to turn the restriction off (every
    // student sees everything again) without touching any data.
    'content_lock' => env('CONTENT_LANGUAGE_LOCK', true),

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
        'lg' => [
            'name'   => 'Luganda',
            'native' => 'Oluganda',
            'short'  => 'LG',
            'dir'    => 'ltr',
        ],
    ],
];
