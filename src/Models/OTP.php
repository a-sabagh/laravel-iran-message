<?php

namespace IRMessage\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use IRMessage\Database\Factories\OTPFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OTP extends Model
{
    use HasFactory;

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

    public static function newFactory()
    {
        return OTPFactory::new();
    }

    protected function setKeysForSaveQuery($query)
    {
        return $query->where('country_code', $this->getAttribute('country_code'))
                     ->where('phone_no', $this->getAttribute('phone_no'));
    }

    #[Scope]
    protected function phone(Builder $query, $phone): void
    {
        $query->where('phone_no', '=', $phone);
    }
}
