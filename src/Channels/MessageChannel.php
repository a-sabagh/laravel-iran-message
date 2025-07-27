<?php

namespace IRMessage\Channels;

use Illuminate\Notifications\Notification;
use IRMessage\Contracts\Factory;

class MessageChannel
{
    public function __construct(
        public Factory $manager
    ){}

    public function send(object $notifiable, Notification $notification) 
    {
        $notification->toMassage()->send();
    }
}
