<?php

namespace IRMessage\Exceptions;

use InvalidArgumentException;

class DriverMissingConfigurationException extends InvalidArgumentException
{
    /**
     * Create a new exception for a missing driver configuration.
     *
     * @param  string  $driver
     * @return static
     */
    public static function make($driver)
    {
        /** @phpstan-ignore new.static */
        return new static("Missing required configuration keys for [{$driver}] Message driver.");
    }
}
