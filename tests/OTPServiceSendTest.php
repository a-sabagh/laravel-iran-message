<?php

namespace IRMessage\Tests;

use Illuminate\Support\Facades\Event;
use IRMessage\Contracts\Factory;
use IRMessage\Contracts\StorageFactory;
use IRMessage\Facades\OTP;
use IRMessage\MessageManager;
use IRMessage\MessageServiceProvider;
use IRMessage\OTPService;
use IRMessage\StorageManager;
use Mockery;
use Orchestra\Testbench\Attributes\WithConfig;
use Orchestra\Testbench\TestCase;

class OTPServiceSendTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    protected function getPackageProviders($app): array
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function test_otp_service_facade(): void
    {
        $this->assertInstanceOf(OTPService::class, OTP::getFacadeRoot());

        $this->assertInstanceOf(MessageManager::class, OTP::message());

        $this->assertInstanceOf(StorageManager::class, OTP::storage());
    }

    public function test_customize_otp_service_message_body(): void
    {
        $expectedMessageBody = 'one-time-password';

        OTP::messageBodyUsing(fn () => $expectedMessageBody);

        $actualMessageBody = OTP::getMessageBody();

        $this->assertEquals($expectedMessageBody, $actualMessageBody);
    }

    public function test_default_otp_service_message_body(): void
    {
        OTP::messageBodyUsing(null);

        $actualMessageBody = OTP::getMessageBody();
        $expectedMessageBody = 'otp';

        $this->assertEquals($expectedMessageBody, $actualMessageBody);
    }

    public function test_customize_otp_service_message_args(): void
    {
        $code = rand(999, 100);

        $expectedMessageArgs = [
            'verification-code' => $code,
        ];

        OTP::messageArgsUsing(fn ($code) => $expectedMessageArgs);

        $actualMessageArgs = OTP::getMessageArgs($code);

        $this->assertEquals($expectedMessageArgs, $actualMessageArgs);
    }

    #[WithConfig('cache.default', 'array')]
    public function test_otp_service_send_message_behaviour(): void
    {
        $code = 1234;
        $countryCode = '98';
        $phoneNumber = '9000000000';
        $recipients = ["{$countryCode}{$phoneNumber}"];

        $messageManagerMock = Mockery::mock(Factory::class);
        $storageManagerMock = Mockery::mock(StorageFactory::class);

        $otpServiceMock = Mockery::mock(OTPService::class, [$messageManagerMock, $storageManagerMock])->makePartial();

        $this->app->instance('irmessage.otp', $otpServiceMock);

        $message = 'one-time-password';
        OTP::messageBodyUsing(fn () => $message);

        $args = ['verification-code' => $code];
        OTP::messageArgsUsing(fn ($code) => $args);

        $storageManagerMock
            ->shouldReceive('store');

        $messageManagerMock
            ->shouldReceive('send')
            ->once()
            ->with($recipients, $message, $args);

        OTP::send($countryCode, $phoneNumber);
    }

    #[WithConfig('cache.default', 'array')]
    public function test_otp_service_send_storage_behaviour(): void
    {
        $code = 12345;
        $decayMinutes = 5;
        $countryCode = '98';
        $phoneNumber = fake()->numerify('9#########');

        $messageManagerMock = Mockery::mock(Factory::class);
        $storageManagerMock = Mockery::mock(StorageFactory::class);

        $otpServiceMock = Mockery::mock(OTPService::class, [$messageManagerMock, $storageManagerMock])->makePartial();

        $otpServiceMock
            ->shouldReceive('getCode')
            ->once()
            ->andReturn($code);

        $otpServiceMock
            ->shouldReceive('decayMinutes')
            ->once()
            ->andReturn($decayMinutes);

        $this->app->instance('irmessage.otp', $otpServiceMock);

        $messageManagerMock->shouldReceive('send');

        $storageManagerMock
            ->shouldReceive('store')
            ->once()
            ->with($countryCode, $phoneNumber, $code, $decayMinutes);

        OTP::send($countryCode, $phoneNumber);
    }
}
