<?php

namespace IRMessage\Drivers;

use IRMessage\Contracts\Driver;
use Stringable;

class LogDriver implements Driver, Stringable
{
    public function send(array|string $recipients, string $message, array $args = [], string $from = null)
    {
        
    }

    public function __toString(): string
    {
        return 'Log';
    }
}