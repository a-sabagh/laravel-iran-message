<?php

namespace IRMessage\Tests\Feature;

use IRMessage\Facades\OTP;
use IRMessage\MessageManager;
use Orchestra\Testbench\TestCase;
use IRMessage\MessageServiceProvider;
use IRMessage\OTPService;

class OTPServiceTest extends TestCase
{
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
}