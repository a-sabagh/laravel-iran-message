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
        'storage' => env('IRMESSAGE_STORAGE', 'database')
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
            'username' => 'Your Username',
            'password' => 'Your Password',
            'from' => 'Your Default From Number',
        ],
    ],

];
