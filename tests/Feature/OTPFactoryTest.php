<?php

namespace IRMessage\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use IRMessage\MessageServiceProvider;
use IRMessage\Models\OTP;
use Orchestra\Testbench\Attributes\WithConfig;
use Orchestra\Testbench\TestCase;

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

    public function test_get_otp_by_phone(): void
    {
        $phoneNo = fake()->numerify('9#########');

        $expected = OTP::factory()->state([
            'phone_no' => $phoneNo,
        ])->create();

        $actual = OTP::phone($expected->phone_no)->first();
        $equality = $expected->is($actual);

        $this->assertTrue($equality);
    }
}
