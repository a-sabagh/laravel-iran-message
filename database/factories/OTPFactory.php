<?php

namespace IRMessage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use IRMessage\Models\OTP;

class OTPFactory extends Factory
{
    protected $model = OTP::class;

    public function definition()
    {
        $otp = fake()->numerify('######');

        return [
            'country_code' => 98,
            'phone_no' => fake()->unique()->numerify('9#########'),
            'code' => Hash::make($otp),
            'available_in' => now()->addMinute(),
        ];
    }
}
