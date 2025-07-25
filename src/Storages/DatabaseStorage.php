<?php

namespace IRMessage\Storages;

use Illuminate\Support\Facades\Hash;
use IRMessage\Contracts\Storage;
use IRMessage\Models\OTP;

class DatabaseStorage implements Storage
{
    public function store(int $countryCode, int $phoneNumber, int $code, int $decayMinutes): bool
    {
        $otpHashed = Hash::make($code);

        return OTP::updateOrInsert(
            ['country_code' => $countryCode, 'phone_no' => $phoneNumber],
            ['otp' => $otpHashed, 'expire_at' => now()->addMinutes($decayMinutes)]
        );
    }
}
