<?php

namespace IRMessage\Facades;

use Illuminate\Support\Facades\Facade;
use IRMessage\Contracts\Factory;

class Message extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
