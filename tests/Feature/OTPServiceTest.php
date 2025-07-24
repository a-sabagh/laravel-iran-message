<?php

namespace IRMessage\Tests\Feature;

use IRMessage\OTPService;
use IRMessage\Facades\OTP;
use IRMessage\MessageManager;
use Orchestra\Testbench\TestCase;
use IRMessage\MessageServiceProvider;
use IRMessage\Concerns\ThrottleAttempt;

class OTPServiceTest extends TestCase
{
    use ThrottleAttempt;

    protected function getPackageProviders($app): array
    {
        return [
            MessageServiceProvider::class
        ];
    }

    public function test_otp_service_facade(): void
    {
        $this->assertInstanceOf(OTPService::class, OTP::getFacadeRoot());

        $this->assertInstanceOf(MessageManager::class, OTP::message());
    }

    public function test_otp_service_static_message_configuration(): void
    {
        $expectedMessageBody = 'one-time-password';

        OTPService::messageBodyUsing(fn() => $expectedMessageBody);

        $actualMessageBody = OTP::getMessageBody();

        $this->assertEquals($expectedMessageBody, $actualMessageBody);
    }
}
