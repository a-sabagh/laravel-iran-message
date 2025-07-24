<?php

namespace IRMessage\Tests;

use IRMessage\Contracts\Factory;
use IRMessage\PendingMessage;
use Orchestra\Testbench\TestCase;

class PendingMessageTest extends TestCase
{
    public function test_pending_message_instanciate(): void
    {
        $recipients = [fake()->phoneNumber()];
        $from = fake()->phoneNumber();
        $message = fake()->sentence(3);
        $args = fake()->words(3);

        $messageManagerMock = $this
            ->mock(
                Factory::class,
                fn ($mock) => $mock
                    ->shouldReceive('driver')
                    ->andReturnSelf()
                    ->shouldReceive('send')
                    ->with($recipients, $message, $from, $args)
                    ->andReturn(true)
            );

        $pendingMessage = new PendingMessage($messageManagerMock);

        $pendingMessage
            ->to($recipients)
            ->from($from)
            ->message($message)
            ->args($args)
            ->send();

        $this->addToAssertionCount(1);
    }
}
