<?php

namespace IRMessage\Contracts;

interface Factory
{
    /**
     * Get an iran message provider implementation.
     *
     * @param  string  $driver
     * @return \IRMessage\Contracts\TransportInterface
     */
    public function driver($driver = null);
}