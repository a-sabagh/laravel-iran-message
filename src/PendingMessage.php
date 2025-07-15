<?php

namespace IRMessage;

use IRMessage\Contracts\Factory;

class PendingMessage
{
    /**
     * The message manager instance.
     *
     * @var \IRMessage\MessageManager
     */
    protected $manager;

    /**
     * The recipients array
     *
     * @var array
     */
    protected $recipients = [];

    /**
     * The "from" number
     *
     * @var string
     */
    public $from;

    /**
     * The "message" body;
     *
     * @var array
     */
    protected $message = [];

    /**
     * The "args" for compiling with message body.
     *
     * @var array
     */
    protected $args = [];

    public function __construct(Factory $manager)
    {
        $this->manager = $manager;
    }

    public function to($recipients): self
    {
        $this->recipients = is_array($recipients) ? $recipients : func_get_args();
        return $this;
    }

    public function from(string $from): self
    {
        $this->from = $from;
        return $this;
    }

    public function message(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function args(array $args): self
    {
        $this->args = $args;
        return $this;
    }

    public function send(): mixed
    {
        return $this->manager->driver()->send($this->recipients, $this->message, $this->from, $this->args);
    }
}