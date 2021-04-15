<?php

namespace Tests\Unit\Auth;

use Mockery as m;
use Tests\TestCase;
use App\Contracts\Actions\CreatesNewUsers;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\Authenticatable;

class CreateNewUserTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }



}
