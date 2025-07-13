<?php

namespace IRMessage;

use Illuminate\Support\ServiceProvider;
use IRMessage\Contracts\Factory;

class MessageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Factory::class, function ($app) {
            return new MessageManager($app);
        });
    }
}