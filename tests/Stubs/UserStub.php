<?php

namespace IRMessage\Tests\Stubs;

use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Notifications\Notifiable;

class UserStub extends AuthUser
{
    use Notifiable;
}
