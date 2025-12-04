<?php

namespace IRMessage\Facades;

use Illuminate\Support\Facades\Facade;
use IRMessage\Contracts\Factory;

/**
 * @method static driver(?string $name = null) Get a driver instance.
 *
 * @see IRMessage\MessageManager
 */
class Message extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
