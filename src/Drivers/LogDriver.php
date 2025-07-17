<?php

namespace IRMessage\Drivers;

use Illuminate\Support\Collection;
use Psr\Log\LoggerInterface;
use IRMessage\Concerns\TranslatableMessage;
use IRMessage\Contracts\Driver;
use Stringable;

class LogDriver implements Driver, Stringable
{
    use TranslatableMessage;

    protected $logger;
    protected Collection $config;

    public function __construct(Collection|array $config, LoggerInterface $logger){
        $this->config = (is_array($config))? collect($config) : $config;

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
