<?php

namespace IRMessage\Drivers;

use IRMessage\Contracts\Driver;


class IPPanel implements Driver
{
    public function send(array|string $recipients, string $message, array $args = [], ?string $from = null)
    {
        
    }
}