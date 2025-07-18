<?php

namespace IRMessage\Tests\Stubs;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as AuthUser;

class UserStub extends AuthUser
{
    use Notifiable;
}