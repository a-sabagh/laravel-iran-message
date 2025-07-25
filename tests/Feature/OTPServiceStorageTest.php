<?php

namespace IRMessage\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use IRMessage\MessageServiceProvider;
use Orchestra\Testbench\Attributes\WithConfig;
use Orchestra\Testbench\TestCase;

#[WithConfig('database.default', 'testing')]
class OTPServiceStorageTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function test_otp_service_database_storage_side_effect(): void {}
}
