<?php

namespace IRMessage\Drivers;

use IRMessage\Contracts\Driver;

class ArrayDriver implements Driver
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
}