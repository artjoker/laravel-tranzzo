<?php

    return [

        /*
        |--------------------------------------------------------------------------
        | Config for Laravel Tranzzo
        |--------------------------------------------------------------------------
        |
        */

        'api_url'       => env('TRANZZO_API_URL', 'https://cpay.tranzzo.com/api/v1'),
        'pos_id'        => env('TRANZZO_POS_ID', null),
        'api_key'       => env('TRANZZO_API_KEY', null),
        'api_secret'    => env('TRANZZO_API_SECRET', null),
        'endpoints_key' => env('TRANZZO_ENDPOINTS_KEY', null),

        'log_enabled' => true,

    ];
