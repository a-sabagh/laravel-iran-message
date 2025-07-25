<?php

namespace IRMessage;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use IRMessage\Channels\MessageChannel;
use IRMessage\Contracts\Factory;
use IRMessage\Contracts\StorageFactory;

class MessageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Factory::class, fn ($app) => new MessageManager($app));

        $this->app->singleton(StorageFactory::class, fn ($app) => new StorageManager($app));

        $this->app->singleton('irmessage.otp', function ($app) {
            $message = $app->make(Factory::class);
            $storage = $app->make(StorageFactory::class);

            return new OTPService($message, $storage);
        });

        $this->mergeConfigFrom(__DIR__.'/../config/irmessage.php', 'irmessage');
    }

    public function boot(): void
    {
        $this->registerPublishing();

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'irmessage');

        Notification::extend('message', fn () => new MessageChannel);
    }

    public function registerPublishing(): void
    {
        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'irmessage-migrations');

        $this->publishes([
            __DIR__.'/../config/irmessage.php' => config_path('irmessage.php'),
        ], 'irmessage-config');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/irmessage'),
        ], 'irmessage-lang');
    }
}
