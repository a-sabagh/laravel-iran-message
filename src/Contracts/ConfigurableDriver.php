<?php

namespace IRMessage\Contracts;

/**
 * Marks a driver as requiring a config array in the application's driver configuration.
 *
 * if a driver implements this interface but the configuration is missing,
 * IRMessage\Exceptions\DriverMissingConfigurationException will be thrown.
 */
interface ConfigurableDriver {}
