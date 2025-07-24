<?php

namespace IRMessage\Facades;

use Illuminate\Support\Facades\Facade;

class OTP extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'irmessage.otp';
    }
}