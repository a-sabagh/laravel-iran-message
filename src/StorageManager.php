<?php

namespace IRMessage;

use Illuminate\Support\Manager;
use IRMessage\Contracts\Storage;
use IRMessage\Contracts\StorageFactory;
use IRMessage\Storages\DatabaseStorage;

class StorageManager extends Manager implements StorageFactory
{
    public function createDatabaseDriver(): Storage
    {
        return new DatabaseStorage;
    }

    public function getDefaultDriver(): string
    {
        return $this->config->get('irmessage.defaults.storage');
    }
}
