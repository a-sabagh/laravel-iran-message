<?php

namespace IRMessage\Tests;

use IRMessage\Contracts\Factory;
use Orchestra\Testbench\TestCase;
use IRMessage\Drivers\IPPanelDriver;
use IRMessage\MessageServiceProvider;
use Mockery\MockInterface;
use Psy\CodeCleaner\AssignThisVariablePass;

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

    public function test_ippannel_send_pattern(): void
    {
        if (!env('TESTING_GATEWAYS')) {
            $this->markTestSkipped('in order to TESTING_GATEWAYS is false, ippanel test disabled');

            return;
        }

        $token = env('IPPANEL_TOKEN', null);
        $pattern = env('IPPANEL_PATTERN', null);
        $recipient = env('IPPANEL_RECIPIENT', null);
        $from = env('IPPANEL_FROM', null);
        $argsJsonEncoded = env('IPPANEL_ARGS', null);

        $this->assertTrue(isset($token, $pattern, $recipient, $from), 'IPPANEL_* environment configuration is not set. driver test failed');

        $config = [
            'token' => $token,
            'from' => $from,
        ];

        $ippanelDriverMock = $this
            ->getMockBuilder(IPPanelDriver::class)
            ->setConstructorArgs(['config' => $config])
            ->onlyMethods(['translate'])
            ->getMock();

        $ippanelDriverMock
            ->expects($this->once())
            ->method('translate')
            ->with('greating')
            ->willReturn($pattern);

        $args = isset($argsJsonEncoded) ? json_decode($argsJsonEncoded, true) : [];

        $response = $ippanelDriverMock->send([$recipient], 'greating', $args);

        $this->assertNotEmpty($response['data']);
        $this->assertTrue($response['meta']['status']);
    }
}
