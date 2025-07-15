<?php

namespace IRMessage\Drivers;

use IRMessage\Contracts\Driver;
use Illuminate\Support\Collection;
use Stringable;

class ArrayDriver implements Driver, Stringable
{
    /**
     * The collection of default configuration for array driver.
     *
     * @var \Illuminate\Support\Collection
     */
    protected Collection $config;

    /**
     * The collection of array messages that send in cycle.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $messages;

    /**
     * Create a new array driver instance.
     */
    public function __construct(Collection $config){
        $this->config = $config;

        $this->messages = new Collection;
    }

    /**
     * {@inheritdoc}
     */
    public function send(array|string $recipients, string $message, array $args = [], string $from = null): void
    {
        $this->messages[] = [
            'recipients' => (array) $recipients,
            'message' => $message,
            'args' => $args,
            'from' => $from ?? $this->config->get('from')
        ];
    }

    /**
     * Retrieve the collection of messages.
     *
     * @return \Illuminate\Support\Collection
     */
    public function messages()
    {
        return $this->messages;
    }

    /**
     * Clear all of the messages from the local collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function flush()
    {
        return $this->messages = new Collection;
    }

    public function __toString(): string
    {
        return 'Array';
    }
}