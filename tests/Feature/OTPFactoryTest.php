<?php

namespace IRMessage\Tests\Feature;

use IRMessage\Models\OTP;
use Orchestra\Testbench\TestCase;
use IRMessage\MessageServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Concerns\WithLaravelMigrations;

class OTPFactoryTest extends TestCase
{
    use WithWorkbench, RefreshDatabase, WithLaravelMigrations;
    
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'testing');
    }

    public function test_otp_factory(): void
    {
        $otp = OTP::factory()->create();

        $this->assertInstanceOf(OTP::class, $otp);
    }
}