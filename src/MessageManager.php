<?php

namespace IRMessage;

use Illuminate\Support\Manager;

class MessageManager extends Manager
{
    public function getDefaultDriver()
    {
        return $this->config['irmessage']['default'];
    }
}