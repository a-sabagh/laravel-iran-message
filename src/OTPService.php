<?php

namespace IRMessage;

use IRMessage\Contracts\Factory;

class OTPService
{
    public function __construct(
        protected Factory $message
    ) {}

    public function send()
    {

    }

    public function message(): Factory
    {
        return $this->message;
    }
}
