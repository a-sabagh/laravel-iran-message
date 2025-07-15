<?php

namespace Tests;

use IRMessage\MessageManager;
use IRMessage\Contracts\Factory;
use IRMessage\Drivers\LogDriver;
use Orchestra\Testbench\TestCase;
use IRMessage\Drivers\ArrayDriver;
use IRMessage\MessageServiceProvider;

class MessageServiceTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('irmessage', [
            'default' => 'log',
            'drivers' => [
                'array' => [
                    'from' => '09361825145'
                ],
                'log' => [
                    'from' => '09361825145'
                ]
            ]
        ]);
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
        $this->app->config->set('irmessage.default', 'log');

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
        $this->app->config->set('irmessage.default', 'log');

        $defaultDriver = $this->app->make(Factory::class)->driver();

        $this->assertInstanceOf(LogDriver::class, $defaultDriver);
    }

    public function test_instanciate_array_driver(): void
    {
        $arrayDriver = $this->app->make(Factory::class)->driver('array');

        $this->assertInstanceOf(ArrayDriver::class, $arrayDriver);
    }

    public function test_array_instance_from(): void
    {
        $from = '09361825145';

        $this->app->config->set('irmessage.drivers.array', [
            'from' => $from
        ]);

        $recipients = [fake()->phoneNumber()];
        $message = fake()->sentence(3);

        $driver = $this->app->make(Factory::class)->driver('array'); 
        $driver->send($recipients, $message);

        $message = $driver->messages()->first();
        $this->assertSame($from, $message['from']);
    }
}
