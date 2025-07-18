<?php

namespace IRMessage\Tests;

use Mockery;
use Orchestra\Testbench\TestCase;
use IRMessage\MessageServiceProvider;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Notifications\Dispatcher;
use IRMessage\Channels\MessageChannel;

class MessageChannelTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class
        ];
    }

    public function test_notification_message_channel_manager_extend(): void
    {
        $channel = $this->app->make(Dispatcher::class)->driver('message');

        $this->assertInstanceOf(MessageChannel::class, $channel);
    }
}
