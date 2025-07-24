<?php

namespace IRMessage;

use IRMessage\Contracts\Factory;

class OTPService
{
    public static $messageBodyCallback;

    public static $messageArgsCallback;

    public function __construct(
        protected Factory $messageManager
    ) {}

    public function send($countryCode, $phoneNumber) 
    {
        $recipients = ["{$countryCode}{$phoneNumber}"];
        $messageBody = $this->getMessageBody();
        $messageArgs = $this->getMessageArgs();
        
        $this->messageManager->send($recipients, $messageBody, $messageArgs);
    }

    public function message(): Factory
    {
        return $this->messageManager;
    }

    public function getMessageBody(): string
    {
        if (is_callable(static::$messageBodyCallback)) {
            return call_user_func(static::$messageBodyCallback);
        }

        return 'otp';
    }

    public function getMessageArgs(): array
    {
        if (is_callable(static::$messageArgsCallback)) {
            return call_user_func(static::$messageArgsCallback);
        }

        $verificationCode = rand(9999, 1000);
        return ['verification_code' => $verificationCode];
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
