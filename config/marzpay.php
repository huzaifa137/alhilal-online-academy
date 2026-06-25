<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MarzPay Payment Gateway Configuration
    |--------------------------------------------------------------------------
    | Uganda-based payment gateway supporting MTN MoMo, Airtel Money, and card.
    | https://wallet.wearemarz.com/documentation
    */

    'base_url' => env('MARZPAY_BASE_URL', 'https://wallet.wearemarz.com/api/v1'),

    // Your API key (public identifier)
    'api_key' => env('MARZPAY_API_KEY', 'marz_jgpZMwS8hfHjDe5f'),

    // Your API secret (keep private)
    'api_secret' => env('MARZPAY_API_SECRET', '7wRtnDp3TsEl7XAX27YPhW4dzMVtnaaK'),

    // Base64-encoded "api_key:api_secret" — used directly in Authorization header.
    // Pre-computed: base64("api_key:api_secret")
    'base64_credentials' => env(
        'MARZPAY_BASE64_CREDENTIALS',
        'bWFyel9qZ3BaTXdTOGhmSGpEZTVmOjd3UnRuRHAzVHNFbDdYQVgyN1lQaFc0ZHpNVnRuYWFL'
    ),

    // Default class fee in UGX (can be overridden per class)
    'default_class_fee' => env('MARZPAY_DEFAULT_CLASS_FEE', 50000),

];
