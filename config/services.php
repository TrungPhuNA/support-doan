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
    'google' => [
        'client_id'     => '344005969356-res0j8a844urcdvtvbp5mk1ciglrhgdt.apps.googleusercontent.com',
        'client_secret' => 'zF8bIjmQN_JM7aM5HdM7ci_D',
        'redirect'      => 'https://tailieu247.net/account/google/callback',
    ],

	'facebook' => [
        'client_id'     => '1158449071160296',
        'client_secret' => '561b2febee9c3d4961317af82e35b021',
        'redirect'      => 'https://tailieu247.net/account/facebook/callback',
    ],
];
