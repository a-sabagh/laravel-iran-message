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

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/irmessage.php' => config_path('irmessage.php'),
        ]);
    }
}
