<?php

namespace IRMessage\Concerns;

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use IRMessage\Events\TooManyOTPRequest;

trait ThrottleAttempt
{
    protected function sendThrottleResponse($phoneNumber, $countryCode)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($phoneNumber, $countryCode)
        );

        throw ValidationException::withMessages([
            "{$countryCode}{$phoneNumber}" => [trans('irmessage::exceptions.otp.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    protected function fireThrottleEvent($countryCode, $phoneNumber): void
    {
        Event::dispatch(new TooManyOTPRequest($countryCode, $phoneNumber));
    }

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
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 1;
    }

    public function decayMinutes()
    {
        return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 2;
    }
}
