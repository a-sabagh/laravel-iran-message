<?php

namespace IRMessage\Tests;

use IRMessage\Contracts\Factory;
use Orchestra\Testbench\TestCase;
use IRMessage\Drivers\IPPanelDriver;
use IRMessage\MessageServiceProvider;
use Mockery\MockInterface;

class IPPanelDriverTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class
        ];
    }

    public function test_ippanel_token(): void
    {
        $token = env('IPPANEL_TOKEN', null);

        $this->assertNotNull($token, 'IPPANEL_TOKEN environment value is not set. all tests must be failed');
    }

    public function test_ippanel_driver_instanciate(): void
    {
        $this->app->config->set('irmessage.drivers.ippanel', ['lang' => 'ippanel_pattern']);

        $manager = $this->app->make(Factory::class);

        $driver = $manager->driver('ippanel');

        $this->assertInstanceOf(IPPanelDriver::class, $driver);
    }

}
