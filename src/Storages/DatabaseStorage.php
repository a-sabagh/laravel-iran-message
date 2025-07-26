<?php

namespace IRMessage\Storages;

use Illuminate\Support\Facades\Hash;
use IRMessage\Contracts\Storage;
use IRMessage\Models\OTP;

class DatabaseStorage implements Storage
{
    public function store(int $countryCode, int $phoneNumber, int $code, int $decayMinutes): void
    {
        $codeHashed = Hash::make($code);

        OTP::updateOrCreate(
            ['country_code' => $countryCode, 'phone_no' => $phoneNumber],
            ['code' => $codeHashed, 'available_in' => now()->addMinutes($decayMinutes)]
        );
    }
}
