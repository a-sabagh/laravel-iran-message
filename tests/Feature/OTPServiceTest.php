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

    public function test_customize_otp_service_message_body(): void
    {
        $expectedMessageBody = 'one-time-password';

        OTP::messageBodyUsing(fn() => $expectedMessageBody);

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
            'verification-code' => rand(999, 100)
        ]; 

        OTP::messageArgsUsing(fn() => $expectedMessageArgs);

        $actualMessageArgs = OTP::getMessageArgs();

        $this->assertEquals($expectedMessageArgs, $actualMessageArgs);
    }
}
