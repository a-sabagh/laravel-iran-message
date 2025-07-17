<?php

namespace Tests;

use Illuminate\Log\LogManager;
use IRMessage\Contracts\Factory;
use Orchestra\Testbench\TestCase;
use IRMessage\MessageServiceProvider;

class LogDriverTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class
        ];
    }

    public function test_log_driver(): void
    {
        $this->app->config->set('irmessage.drivers.log', ['lang' => 'log']);

        $message = $this->app->make(Factory::class);

        $messageLogger = $message->driver('log')->logger();

        $this->assertInstanceOf(LogManager::class, $messageLogger);
    }
}
