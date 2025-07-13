<?php

namespace IRMessage;

use IRMessage\Contracts\Factory;
use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Factory::class, function ($app) {
            return new MessageManager($app);
        });
    }
}