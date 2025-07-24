<?php

namespace IRMessage;

use Illuminate\Support\Manager;
use IRMessage\Contracts\Driver;
use IRMessage\Contracts\Factory;
use IRMessage\Drivers\ArrayDriver;
use IRMessage\Drivers\IPPanelDriver;
use IRMessage\Drivers\LogDriver;
use IRMessage\Exceptions\DriverMissingConfigurationException;
use Psr\Log\LoggerInterface;

class MessageManager extends Manager implements Factory
{
    public function getDefaultDriver()
    {
        return $this->config['irmessage']['default'];
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

    protected function buildDriver(string $driver, array $parameters): Driver
    {
        if (empty($parameters['config'])) {
            throw DriverMissingConfigurationException::make($driver);
        }

        return new $driver(...$parameters);
    }
}
