<?php

namespace IRMessage;

use Illuminate\Support\Facades\Event;
use IRMessage\Concerns\ThrottleAttempt;
use IRMessage\Contracts\Factory;
use IRMessage\Contracts\StorageFactory;
use IRMessage\Events\OTPRequestSend;

class OTPService
{
    use ThrottleAttempt;

    public static $messageBodyCallback;

    public static $messageArgsCallback;

    public function __construct(
        protected Factory $messageManager,
        protected StorageFactory $storageManager
    ) {}

    public function send($countryCode, $phoneNumber)
    {
        if ($this->hasTooManyAttempts($countryCode, $phoneNumber)) {
            $this->fireThrottleEvent($countryCode, $phoneNumber);

            return $this->sendThrottleResponse($countryCode, $phoneNumber);
        }

        $code = $this->getCode();
        $decayMinutes = $this->decayMinutes();

        $recipients = ["{$countryCode}{$phoneNumber}"];
        $messageBody = $this->getMessageBody();
        $messageArgs = $this->getMessageArgs($code);

        $this->message()->send($recipients, $messageBody, $messageArgs);

        $this->storage()->store($countryCode, $phoneNumber, $code, $decayMinutes);

        $this->incrementAttempts($countryCode, $phoneNumber);

        Event::dispatch(new OTPRequestSend($phoneNumber, $countryCode, $code));
    }

    public function message(): Factory
    {
        return $this->messageManager;
    }

    public function storage(): StorageFactory
    {
        return $this->storageManager;
    }

    public function getMessageBody(): string
    {
        if (is_callable(static::$messageBodyCallback)) {
            return call_user_func(static::$messageBodyCallback);
        }

        return 'otp';
    }

    public function getCode(): int
    {
        return rand(9999, 1000);
    }

    public function getMessageArgs($code): array
    {
        if (is_callable(static::$messageArgsCallback)) {
            return call_user_func(static::$messageArgsCallback, [$code]);
        }

        return ['verification_code' => $code];
    }

    public static function messageBodyUsing($callback): void
    {
        static::$messageBodyCallback = $callback;
    }

    public static function messageArgsUsing($callback): void
    {
        static::$messageArgsCallback = $callback;
    }
}
