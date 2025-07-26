<?php

namespace IRMessage\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use IRMessage\Contracts\Factory;
use IRMessage\Contracts\StorageFactory;
use IRMessage\Facades\OTP;
use IRMessage\MessageServiceProvider;
use IRMessage\OTPService;
use Mockery;
use Orchestra\Testbench\TestCase;

class OTPServiceVerifyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    protected function defineEnvironment($app)
    {
        $app->config->set('database.default', 'testing');
        $app->config->set('cache.default', 'array');
        $app->config->set('irmessage.defaults.storage', 'database');
    }

    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function test_otp_service_verify_message_behaviour(): void
    {
        $code = 1234;
        $countryCode = '98';
        $phoneNumber = '9000000000';

        $messageManagerMock = Mockery::mock(Factory::class);
        $storageManager = $this->app->make(StorageFactory::class);

        $messageManagerMock->shouldReceive('send');

        $otpServiceMock = Mockery::mock(OTPService::class, [$messageManagerMock, $storageManager])->makePartial();

        $otpServiceMock->shouldReceive('getCode')->once()->andReturn($code);

        $this->app->instance('irmessage.otp', $otpServiceMock);

        OTP::send($countryCode, $phoneNumber);

        $verifyOTP = OTP::verify($countryCode, $phoneNumber, $code);
        $this->assertTrue($verifyOTP);

        $this->travel(OTP::decayMinutes() + 10)->minutes();
        $verifyOTP = OTP::verify($countryCode, $phoneNumber, $code);
        $this->assertFalse($verifyOTP);
    }
}
