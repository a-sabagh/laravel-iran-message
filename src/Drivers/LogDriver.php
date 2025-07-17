<?php

namespace IRMessage\Drivers;

use Psr\Log\LoggerInterface;
use IRMessage\Concerns\TranslatableMessage;
use IRMessage\Contracts\Driver;
use Stringable;

class LogDriver implements Driver, Stringable
{
    use TranslatableMessage;

    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logger(): LoggerInterface
    {
        return $this->logger;
    }

    public function send(array|string $recipients, string $message, array $args = [], ?string $from = null) {}

    public function __toString(): string
    {
        return 'Log';
    }
}
