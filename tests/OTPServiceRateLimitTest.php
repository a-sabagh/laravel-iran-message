<?php

namespace IRMessage\Tests;

use Illuminate\Validation\ValidationException;
use IRMessage\Contracts\Factory;
use IRMessage\Facades\OTP;
use IRMessage\MessageServiceProvider;
use Orchestra\Testbench\Attributes\WithEnv;
use Orchestra\Testbench\TestCase;

class OTPServiceRateLimitTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    #[WithEnv('CACHE_STORE', 'array')]
    public function test_otp_service_has_threshold_attempt(): void
    {
        $this->expectException(ValidationException::class);

        $countryCode = '98';
        $phoneNumber = fake()->numerify('9#########');

        $messageManager = $this->mock(Factory::class);

        $messageManager
            ->shouldReceive('send')
            ->andReturn(false);

        OTP::send($countryCode, $phoneNumber);

        $this->travel(5)->second();

        $messageManager
            ->shouldNotReceive('send');

        OTP::send($countryCode, $phoneNumber);
    }
}
