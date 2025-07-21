<?php

namespace IRMessage\Models;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    public $timestamps = false;
    public $incrementing = false;

    protected $table = 'phone_otps';
    protected $primaryKey = null;

    protected $fillable = [
        'country_code',
        'phone_no',
        'otp',
        'time',
    ];

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('country_code', $this->getAttribute('country_code'))
                     ->where('phone_no', $this->getAttribute('phone_no'));
    }
}
