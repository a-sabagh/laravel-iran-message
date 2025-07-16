<?php

namespace IRMessage\Drivers;

use IRMessage\Concerns\TranslatableMessage;
use IRMessage\Contracts\Driver;
use Stringable;

class LogDriver implements Driver, Stringable
{
    use TranslatableMessage;
    
    public function send(array|string $recipients, string $message, array $args = [], string $from = null)
    {
        
    }

    public function __toString(): string
    {
        return 'Log';
    }
}