<?php

namespace IRMessage\Channels;

use Illuminate\Notifications\Notification;

class MessageChannel
{
    public function send(object $notifiable, Notification $notification)
    {
        $notification->toMessage($notifiable)->send();
    }
}
