<?php

namespace IRMessage\Drivers;

use Illuminate\Support\Collection;
use IRMessage\Concerns\TranslatableMessage;
use IRMessage\Contracts\ConfigurableDriver;
use IRMessage\Contracts\Driver;
use Psr\Log\LoggerInterface;
use Stringable;

class LogDriver implements ConfigurableDriver, Driver, Stringable
{
    use TranslatableMessage;

    protected $logger;

    protected Collection $config;

    public function __construct(Collection|array $config, LoggerInterface $logger)
    {
        $this->config = (is_array($config)) ? collect($config) : $config;

        $this->logger = $logger;
    }

    public function logger(): LoggerInterface
    {
        return $this->logger;
    }

    public function send(array|string $recipients, string $message, array $args = [], ?string $from = null)
    {
        $rawMessageLine = sprintf(
            "[%s] New Message: '%s' | To: %s | From: %s | Args: %s",
            date('Y-m-d H:i:s'),
            $this->translate($message),
            is_array($recipients) ? implode(', ', $recipients) : $recipients,
            $from ?? $this->config->get('from'),
            json_encode($args)
        );

        $this->logger()->debug($rawMessageLine);
    }

    public function __toString(): string
    {
        return 'Log';
    }
}
