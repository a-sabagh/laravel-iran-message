<?php

namespace IRMessage\Tests;

use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use IRMessage\Contracts\Factory;
use IRMessage\Contracts\StorageFactory;
use IRMessage\Facades\OTP;
use IRMessage\MessageServiceProvider;
use IRMessage\OTPService;
use Mockery;
use Orchestra\Testbench\TestCase;

class OTPServiceRateLimitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app->config->set('cache.default', 'array');
    }

    public function test_otp_service_has_threshold_attempt(): void
    {
        $this->expectException(ValidationException::class);

        $countryCode = '98';
        $phoneNumber = fake()->numerify('9#########');

        $messageManagerMock = Mockery::mock(Factory::class);
        $storageManagerMock = Mockery::mock(StorageFactory::class);

        $messageManagerMock->shouldReceive('send');
        $storageManagerMock->shouldReceive('store');

        $otpServiceMock = Mockery::mock(OTPService::class, [$messageManagerMock, $storageManagerMock])->makePartial();

        $this->app->instance('irmessage.otp', $otpServiceMock);

        OTP::send($countryCode, $phoneNumber);

        $this->travel(5)->second();

        $messageManagerMock
            ->shouldNotReceive('send');

        OTP::send($countryCode, $phoneNumber);
    }

    public function test_otp_service_send_threshold_was_reset_on_decay_time(): void
    {
        $countryCode = '98';
        $phoneNumber = fake()->numerify('9#########');

        $messageManagerMock = Mockery::mock(Factory::class);
        $storageManagerMock = Mockery::mock(StorageFactory::class);

        $messageManagerMock->shouldReceive('send');
        $storageManagerMock->shouldReceive('store');

        $otpServiceMock = Mockery::mock(OTPService::class, [$messageManagerMock, $storageManagerMock])->makePartial();

        $this->app->instance('irmessage.otp', $otpServiceMock);

        $decayMinutes = OTP::decayMinutes();

        OTP::send($countryCode, $phoneNumber);

        $this->travel($decayMinutes + 1)->minute();

        OTP::send($countryCode, $phoneNumber);

        $this->addToAssertionCount(1);
    }
}
