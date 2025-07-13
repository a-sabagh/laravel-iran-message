<?php

namespace IRMessage\Facades;

use IRMessage\Contracts\Factory;
use Illuminate\Support\Facades\Facade;

class Message extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}