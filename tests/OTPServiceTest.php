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
        $expectedMessageArgs = [
            'verification-code' => rand(999, 100),
        ];

        OTP::messageArgsUsing(fn () => $expectedMessageArgs);

        $actualMessageArgs = OTP::getMessageArgs();

        $this->assertEquals($expectedMessageArgs, $actualMessageArgs);
    }

    #[WithConfig('cache.default', 'array')]
    public function test_otp_service_send(): void
    {
        $countryCode = '98';
        $phoneNumber = '9000000000';
        $recipients = ["{$countryCode}{$phoneNumber}"];

        $messageManager = $this->mock(Factory::class);

        $message = 'one-time-password';
        OTP::messageBodyUsing(fn () => $message);

        $args = [
            'verification-code' => rand(999, 100),
        ];
        OTP::messageArgsUsing(fn () => $args);

        $messageManager
            ->shouldReceive('send')
            ->once()
            ->with($recipients, $message, $args);

        OTP::send($countryCode, $phoneNumber);
    }
}
