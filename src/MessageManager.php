<?php

namespace IRMessage;

use Illuminate\Support\Manager;
use IRMessage\Contracts\Driver;
use IRMessage\Contracts\Factory;
use IRMessage\Drivers\LogDriver;
use IRMessage\Drivers\ArrayDriver;

class MessageManager extends Manager implements Factory
{
    public function getDefaultDriver()
    {
        return $this->config['irmessage']['default'];
    }

    public function createLogDriver(): Driver
    {
        return new LogDriver;
    }

    public function createArrayDriver(): Driver
    {
        $config = $this->config->get('irmessage.drivers.array');

        return new ArrayDriver(collect($config));
    }
}
