<?php

return [

    'default' => 'staging',

    'modes' => [
        [
            'mode' => 'production',
            'base_url' => 'https://ipg.toman.ir',
            'token' => env('TOMANPAY_TOKEN'),
        ],
        [
            'mode' => 'staging',
            'base_url' => 'https://ipg-staging.toman.ir',
            'token' => env('TOMANPAY_TOKEN'),
        ],
    ],
];
