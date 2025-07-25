<?php

namespace IRMessage\Tests;

use IRMessage\Contracts\Factory;
use IRMessage\Facades\OTP;
use IRMessage\MessageManager;
use IRMessage\MessageServiceProvider;
use IRMessage\OTPService;
use IRMessage\StorageManager;
use Orchestra\Testbench\Attributes\WithConfig;
use Orchestra\Testbench\TestCase;

class OTPServiceTest extends TestCase
{
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
        $code = rand(999, 100);
        $countryCode = '98';
        $phoneNumber = '9000000000';
        $recipients = ["{$countryCode}{$phoneNumber}"];

        $messageManager = $this->mock(Factory::class);

        $this
            ->mock(OTPService::class)
            ->makePartial()
            ->shouldReceive('getCode')
            ->andReturn($code);

        $message = 'one-time-password';
        OTP::messageBodyUsing(fn () => $message);

        $args = ['verification-code' => $code];
        OTP::messageArgsUsing(fn ($code) => $args);

        $messageManager
            ->shouldReceive('send')
            ->once()
            ->with($recipients, $message, $args);

        OTP::send($countryCode, $phoneNumber);
    }
}
