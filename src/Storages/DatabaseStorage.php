<?php

namespace IRMessage\Storages;

use Illuminate\Support\Facades\Hash;
use IRMessage\Contracts\Storage;
use IRMessage\Models\OTP;

class DatabaseStorage implements Storage
{
    public function store(array $data): bool
    {
        $otp = Hash::make($data['otp']);

        return OTP::updateOrInsert(
            ['country_code' => $data['country_code'], 'phone_no' => $data['phone_no']],
            ['otp' => $otp, 'expire_at' => $data['expire_at']]
        );
    }
}
