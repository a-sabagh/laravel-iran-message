<?php

namespace IRMessage\Contracts;

interface Driver
{
    public function send(array|string $recipients, string $message, array $args = [], string $from = null);
}