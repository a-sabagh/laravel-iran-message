<?php

namespace IRMessage\Concerns;

use Illuminate\Cache\RateLimiter;

trait ThrottleAttempt
{
    protected function hasTooManyAttempts($phoneNumber, $countryCode)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($phoneNumber, $countryCode),
            $this->maxAttempts()
        );
    }

    protected function incrementAttempts($phoneNumber, $countryCode)
    {
        $this->limiter()->increment(
            $this->throttleKey($phoneNumber, $countryCode)
        );
    }

    protected function clearAttempts(int $phoneNumber, int $countryCode = 98)
    {
        $this->limiter()->clear($this->throttleKey($phoneNumber, $countryCode));
    }

    protected function throttleKey(int $phoneNumber, int $countryCode = 98)
    {
        return "otp:{$countryCode}:{$phoneNumber}";
    }

    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
    }

    public function decayMinutes()
    {
        return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1;
    }
}
