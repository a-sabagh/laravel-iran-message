<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This value determines which of the following driver to use.
    | You can switch to a another driver at runtime using strategy design pattern.
    |
    */
    'defaults' => [
        'message' => env('IRMESSAGE_DRIVER', 'array'),
        'storage' => env('IRMESSAGE_STORAGE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | List of Drivers
    |--------------------------------------------------------------------------
    |
    | These are the list of drivers to use for this package.
    | You can change the name. Then you'll have to change
    | it in the map array too.
    |
    */
    'drivers' => [
        'ippanel' => [
            'token' => env('IRMESSAGE_IPPANEL_TOKEN', null),
            'lang' => env('IRMESSAGE_IPPANEL_LANG', 'ippanel_pattern'),
            'username' => env('IRMESSAGE_IPPANEL_USERNAME', null),
            'password' => env('IRMESSAGE_IPPANEL_PASSWORD', null),
            'from' => env('IRMESSAGE_IPPANEL_FROM', null),
        ],
        'array' => [
            'lang' => 'array',
        ],
    ],

];
