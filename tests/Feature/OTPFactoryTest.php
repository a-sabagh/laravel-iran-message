<?php

namespace IRMessage\Tests\Feature;

use IRMessage\Models\OTP;
use Orchestra\Testbench\TestCase;
use IRMessage\MessageServiceProvider;
use Orchestra\Testbench\Attributes\WithConfig;
use Illuminate\Foundation\Testing\RefreshDatabase;

#[WithConfig('database.default', 'testing')] 
class OTPFactoryTest extends TestCase
{
    use RefreshDatabase;
    
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function test_otp_factory(): void
    {
        $otp = OTP::factory()->create();

        $this->assertInstanceOf(OTP::class, $otp);
    }
}