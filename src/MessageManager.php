<?php

namespace IRMessage;

use Illuminate\Support\Manager;
use IRMessage\Contracts\ConfigurableDriver;
use IRMessage\Contracts\Driver;
use IRMessage\Contracts\Factory;
use IRMessage\Drivers\ArrayDriver;
use IRMessage\Drivers\IPPanelDriver;
use IRMessage\Drivers\LogDriver;
use IRMessage\Drivers\NullDriver;
use IRMessage\Exceptions\DriverMissingConfigurationException;
use Psr\Log\LoggerInterface;

class MessageManager extends Manager implements Factory
{
    public function getDefaultDriver()
    {
        return $this->config['irmessage']['defaults']['message'];
    }

    /** @see IRMessage\Tests\NullDriverTest */
    public function createNullDriver(): Driver
    {
        return $this->buildDriver(NullDriver::class, []);
    }

    public function createLogDriver(): Driver
    {
        $parameters = [
            'config' => $this->config->get('irmessage.drivers.log'),
            'logger' => $this->container->make(LoggerInterface::class),
        ];

        return $this->buildDriver(LogDriver::class, $parameters);
    }

    public function createIppanelDriver(): Driver
    {
        $parameters = ['config' => $this->config->get('irmessage.drivers.ippanel')];

        return $this->buildDriver(IPPanelDriver::class, $parameters);
    }

    public function createArrayDriver(): Driver
    {
        $parameters = ['config' => $this->config->get('irmessage.drivers.array')];

        return $this->buildDriver(ArrayDriver::class, $parameters);
    }

    /**
     * Determine whether a driver that implements ConfigurableDriver
     * is missing its required configuration array.
     * on return true probably caller thrown IRMessage\Exceptions\DriverMissingConfigurationException
     *
     * @param  string  $driver  Fully qualified driver `class name`.
     * @param  array  $parameters  Parameters passed to the driver constructor.
     * @return bool True if the driver configurable required and it's missing config.
     */
    protected function missingRequiredConfig(string $driver, array $parameters): bool
    {
        $driverImplements = class_implements($driver);
        $driverClassImplementConfigurableInterface = in_array(ConfigurableDriver::class, $driverImplements);

        if (! $driverClassImplementConfigurableInterface) {
            return false;
        }

        return ! isset($parameters['config']) || empty($parameters['config']);
    }

    protected function buildDriver(string $driver, array $parameters): Driver
    {
        if ($this->missingRequiredConfig($driver, $parameters)) {
            throw new DriverMissingConfigurationException(
                "Driver [{$driver}] is missing required configuration."
            );
        }

        return new $driver(...$parameters);
    }
}
