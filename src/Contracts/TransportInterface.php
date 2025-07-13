<?php

namespace IRMessage\Contracts;

interface TransportInterface
{
    /**
     * @throws TransportExceptionInterface
     */
    public function send();
}