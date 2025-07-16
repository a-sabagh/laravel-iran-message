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

        $this->mergeConfigFrom(__DIR__ . '/../config/irmessage.php', 'irmessage');
    }

    public function boot(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'irmessage');

        $this->publishes([
            __DIR__ . '/../config/irmessage.php' => config_path('irmessage.php'),
            __DIR__ . '/../lang' => $this->app->langPath('vendor/irmessage'),
        ]);
    }
}
