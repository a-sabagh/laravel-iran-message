<?php

namespace IRMessage;

use Illuminate\Support\Manager;
use IRMessage\Contracts\Driver;
use IRMessage\Contracts\Factory;
use IRMessage\Drivers\LogDriver;
use IRMessage\Drivers\ArrayDriver;
use IRMessage\Exceptions\DriverMissingConfigurationException;

class MessageManager extends Manager implements Factory
{
    public function getDefaultDriver()
    {
        return $this->config['irmessage']['default'];
    }

    public function createLogDriver(): Driver
    {
        $config = $this->config->get('irmessage.drivers.log');

        return $this->buildDriver(LogDriver::class, $config);
    }

    public function createArrayDriver(): Driver
    {
        $config = $this->config->get('irmessage.drivers.array');

        return $this->buildDriver(ArrayDriver::class, $config);
    }

    protected function buildDriver(string $driver, $config): Driver
    {
        if(empty($config)){
            throw DriverMissingConfigurationException::make($driver);
        }

        return new $driver($config);
    }
}
