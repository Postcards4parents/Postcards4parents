<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
  
  'facebook' => [
        'client_id' => '670881017107729',
        'client_secret' => 'ba946f10f7c1a89025351a80991cc6d5',
        'redirect' => 'https://postcardsforparents.com/callback/facebook',
    ],
    'google' => [
        'client_id' => '879186188388-b861t6b8p2jo7m84dsm4qqmlthg5tbui.apps.googleusercontent.com',
        'client_secret' => 'yCjm8t16ymBwiefB_xrav79s',
        'redirect' => 'https://postcardsforparents.com/callback/google',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'mandrill' => [
        'secret' => 'yURspE__ZJXq86s4Le1QHQ',
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

];
