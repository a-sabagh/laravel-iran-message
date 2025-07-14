<?php

namespace IRMessage;

use Illuminate\Support\Manager;
use IRMessage\Contracts\Driver;
use IRMessage\Contracts\Factory;
use IRMessage\Driver\LogDriver;

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
}