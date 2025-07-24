<?php

namespace IRMessage\Tests;

use Illuminate\Contracts\Notifications\Dispatcher;
use Illuminate\Notifications\Notification;
use IRMessage\Channels\MessageChannel;
use IRMessage\MessageServiceProvider;
use IRMessage\Tests\Stubs\UserStub;
use Orchestra\Testbench\TestCase;

class MessageChannelTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            MessageServiceProvider::class,
        ];
    }

    public function test_notification_message_channel_manager_extend(): void
    {
        $channel = $this->app->make(Dispatcher::class)->driver('message');

        $this->assertInstanceOf(MessageChannel::class, $channel);
    }

    public function test_notification_message_channel_send(): void
    {
        $userConfiguredStub = new UserStub;

        $notificationMock = $this->mock(Notification::class)->makePartial();

        $notificationMock
            ->shouldReceive('via')
            ->with($userConfiguredStub)
            ->andReturn(['message']);

        $this
            ->mock(MessageChannel::class)
            ->shouldReceive('send')
            ->with($userConfiguredStub, $notificationMock);

        $userConfiguredStub->notify($notificationMock);

        $this->addToAssertionCount(1);
    }
}
