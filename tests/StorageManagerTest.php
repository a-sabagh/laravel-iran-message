<?php

namespace IRMessage\Tests;

use IRMessage\Contracts\StorageFactory;
use IRMessage\MessageServiceProvider;
use IRMessage\StorageManager;
use irmessage\Storages\DatabaseStorage;
use Orchestra\Testbench\Attributes\WithConfig;
use Orchestra\Testbench\TestCase;

class StorageManagerTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function test_manager_can_instansiate_database_storage(): void
    {
        $storage = $this->app->make(StorageFactory::class);

        $this->assertInstanceOf(StorageManager::class, $storage);

        $this->assertInstanceOf(DatabaseStorage::class, $storage->driver('database'));
    }

    #[WithConfig('irmessage.defaults.storage', 'database')]
    public function test_storage_manager_default_driver(): void
    {
        $storage = $this->app->make(StorageFactory::class);

        $this->assertEquals('database', $storage->getDefaultDriver());

        $this->assertInstanceOf(DatabaseStorage::class, $storage->driver());
    }
}
