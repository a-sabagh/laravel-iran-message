<?php

namespace Tests;

use Illuminate\Log\Logger;
use Illuminate\Log\LogManager;
use IRMessage\Contracts\Factory;
use IRMessage\Drivers\LogDriver;
use Orchestra\Testbench\TestCase;
use IRMessage\MessageServiceProvider;
use Mockery;
use Psr\Log\LoggerInterface;

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

    public function test_log_driver_send(): void
    {
        $loggerMock = Mockery::mock(LoggerInterface::class);

        $logDriver = new LogDriver(['lang' => 'log'], $loggerMock);

        $messageData = [
            'recipients' => [fake()->phoneNumber()],
            'message' => 'greating',
            'from' => fake()->phoneNumber(),
            'args' => []
        ];

        $loggerMock
            ->shouldReceive('debug')
            ->once();

        $logDriver->send(...$messageData);
    }

    public function test_log_driver_send_from(): void
    {
        $from = fake()->phoneNumber();

        $this->app->config->set('irmessage.drivers.log', ['from' => $from]);

        $loggerMock = $this->mock(LoggerInterface::class);

        $message = $this->app->make(Factory::class);

        $messageData = [
            'recipients' => [fake()->phoneNumber()],
            'message' => 'greating',
            'from' => null,
            'args' => []
        ];

        $loggerMock
            ->shouldReceive('debug')
            ->once()
            ->with(Mockery::on(fn($rawMessage) => str_contains($rawMessage, $from)));

        $message->driver('log')->send(...$messageData);
    }

    public function test_log_driver_translate_message_body(): void
    {
        $this->app->config->set('irmessage.drivers.log', ['lang' => 'log']);

        $loggerMock = $this->mock(LoggerInterface::class);

        $logDriver = $this->app->make(Factory::class)->driver('log');

        $messageData = [
            'recipients' => [fake()->phoneNumber()],
            'message' => 'greating',
            'from' => fake()->phoneNumber(),
            'args' => []
        ];
        
        $actualMessageBody = trans("irmessage::messages.log.greating");

        $loggerMock
            ->shouldReceive('debug')
            ->once()
            ->with(Mockery::on(fn($rawMessage) => str_contains($rawMessage, $actualMessageBody)));

        $logDriver->send(...$messageData);
    }

}
