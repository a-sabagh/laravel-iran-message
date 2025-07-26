<?php

namespace IRMessage\Events;

class OTPRequestSend
{
    public function __construct(
        public int $countryCode,
        public int $phoneNumber,
        public int $code
    ) {}
}
