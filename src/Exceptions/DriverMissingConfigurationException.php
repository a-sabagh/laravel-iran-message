<?php

namespace IRMessage\Exceptions;

use InvalidArgumentException;

class DriverMissingConfigurationException extends InvalidArgumentException
{
    /**
     * Create a new exception for a missing configuration.
     *
     * @param  string  $driver
     * @param  array<int, string>  $keys
     * @return static
     */
    public static function make($driver, $keys)
    {
        /** @phpstan-ignore new.static */
        return new static("Missing required configuration keys for [{$driver}] OAuth driver.");
    }
}