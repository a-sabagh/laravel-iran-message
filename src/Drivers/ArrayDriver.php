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
    protected Collection $defaults;
}