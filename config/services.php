<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' => [
        'secret' => env('STRIPE_SECRET_KEY'),
        'publishable' => env('STRIPE_PUBLISHABLE_KEY'),
    ],

    'paypal' => [
        'client_id' => env('PAPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_SECRET_KEY'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', null),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', null),
        'redirect_uri' => env('GOOGLE_REDIRECT_URI', null),
        'calendar_id' => env('GOOGLE_CALENDAR_ID', null)
    ]

];
