<?php

namespace IRMessage\Events;

class TooManyOTPRequest
{
    public function __construct(
        public string $countryCode,
        public string $phoneNumber
    ) {}
}
