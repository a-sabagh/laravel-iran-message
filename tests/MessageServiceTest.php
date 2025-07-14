<?php

namespace Tests;

use IRMessage\MessageManager;
use IRMessage\Contracts\Factory;
use IRMessage\Drivers\LogDriver;
use Orchestra\Testbench\TestCase;
use IRMessage\MessageServiceProvider;

class MessageServiceTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('irmessage.default', 'log');
    }

    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function test_message_service_service(): void
    {
        $messageService = $this->app->make(Factory::class);
        $this->assertInstanceOf(MessageManager::class, $messageService);
    }

    public function test_message_manager_default_config(): void
    {
        $defaultDriver = $this->app->make(Factory::class)->getDefaultDriver();

        $this->assertSame('log', $defaultDriver);
    }

    public function test_instanciate_log_driver(): void
    {
        $logDriver = $this->app->make(Factory::class)->driver('log');

        $this->assertInstanceOf(LogDriver::class, $logDriver);
    }

    public function test_instanciate_default_driver(): void
    {
        $defaultDriver = $this->app->make(Factory::class)->driver();

        $this->assertInstanceOf(LogDriver::class, $defaultDriver);
    }
}
