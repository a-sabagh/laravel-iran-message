<?php

namespace Tests;

use IRMessage\MessageManager;
use IRMessage\Contracts\Factory;
use Orchestra\Testbench\TestCase;
use IRMessage\MessageServiceProvider;

class MessageServiceTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function test_message_service_service(): void
    {
        $messageService = $this->app->make(Factory::class);
        $this->assertInstanceOf(MessageManager::class, $messageService);
    }
}
