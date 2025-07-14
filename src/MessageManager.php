<?php

namespace IRMessage;

use Illuminate\Support\Manager;
use IRMessage\Contracts\Driver;
use IRMessage\Driver\LogDriver;

class MessageManager extends Manager
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