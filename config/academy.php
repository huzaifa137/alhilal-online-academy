<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mobile app (Google Play) link
    |--------------------------------------------------------------------------
    | Single source of truth for the Play Store link used by the WhatsApp
    | button and the "Get the app" widgets on the Teacher, Admin and Student
    | dashboards. Override with PLAY_STORE_URL in .env if it ever changes.
    */
    'play_store_url' => env(
        'PLAY_STORE_URL',
        'https://play.google.com/store/apps/details?id=co.median.android.eekyjjy&hl=en'
    ),

];
