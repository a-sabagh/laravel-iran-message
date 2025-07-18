<?php

namespace IRMessage\Tests\Stubs;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchestra\Testbench\Factories\UserFactory;

class UserStub extends AuthUser
{
    use Notifiable;
}