<?php

namespace IRMessage\Tests;

use IRMessage\Drivers\NullDriver;
use IRMessage\Facades\Message;
use IRMessage\MessageServiceProvider;
use Orchestra\Testbench\TestCase;

class NullDriverTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function test_manager_can_instansiate_null_driver(): void
    {
        $nullObjectDriver = Message::driver('null');

        $this->assertInstanceOf(NullDriver::class, $nullObjectDriver);
    }

    public function test_manager_can_instansiate_null_driver_as_default(): void
    {
        $this->app->config->set('irmessage.defaults.message', 'null');

        $nullObjectDriver = Message::driver();

        $this->assertInstanceOf(NullDriver::class, $nullObjectDriver);
    }

    public function test_null_driver_send_method_nothing_to_do_without_any_exception(): void
    {
        Message::driver('null')->send('09120000000', 'Test message');

        $this->addToAssertionCount(1);
    }

    public function test_null_driver_missing_configuration(): void
    {
        $this->app->config->offsetUnset('irmessage.drivers.null');

        $nullObjectDriver = Message::driver('null');

        $this->assertInstanceOf(NullDriver::class, $nullObjectDriver);
    }
}
