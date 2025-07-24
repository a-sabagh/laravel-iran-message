<?php

namespace IRMessage\Tests;

use Illuminate\Support\Collection;
use IRMessage\Concerns\TranslatableMessage;
use IRMessage\MessageServiceProvider;
use Orchestra\Testbench\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class TranslatableMessageTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public static function driverProvider(): array
    {
        return [
            ['ippanel_pattern'],
            ['log'],
        ];
    }

    #[DataProvider('driverProvider')]
    public function test_translatable_message_trait($driver): void
    {
        $this->app->config->set('app.locale', 'en');

        $stub = new class
        {
            use TranslatableMessage;

            public Collection $config;
        };

        $stub->config = collect(['lang' => $driver]);

        $this->assertEquals(
            trans("irmessage::messages.{$driver}.greating"),
            $stub->translate('greating')
        );
    }
}
