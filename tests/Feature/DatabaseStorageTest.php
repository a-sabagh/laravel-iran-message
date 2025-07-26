<?php

namespace IRMessage\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use IRMessage\MessageServiceProvider;
use IRMessage\Models\OTP;
use IRMessage\Storages\DatabaseStorage;
use Orchestra\Testbench\Attributes\WithConfig;
use Orchestra\Testbench\TestCase;

#[WithConfig('database.default', 'testing')]
class DatabaseStorageTest extends TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function test_otp_service_database_storage_side_effect(): void
    {
        $countryCode = '98';
        $phoneNumber = fake()->numerify('9##########');
        $code = rand(9999, 1000);
        $decayMinutes = 1;

        $storage = new DatabaseStorage;

        $storage->store($countryCode, $phoneNumber, $code, $decayMinutes);

        $otp = OTP::phone($phoneNumber)->first();

        $this->assertDatabaseHas('phone_otps', ['country_code' => $countryCode, 'phone_no' => $phoneNumber]);
        $this->assertTrue(Hash::check($code, $otp['code']));
        $this->assertGreaterThanOrEqual(now()->addMinutes($decayMinutes), $otp['available_in']);
    }
}
