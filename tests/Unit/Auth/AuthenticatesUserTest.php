<?php

namespace Tests\Unit\Auth;

use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Actions\Auth\AuthenticateUser;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticatesUserTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        m::close();
    }

    public function testAuthenticateUser()
    {
        $user = create(User::class, $credentials = [
            'email' => 'james.silverman@monster.com',
            'password' => Hash::make('cthuluEmployee'),
        ]);

        $guard = m::mock(StatefulGuard::class);
        $guard->shouldReceive('attempt')
            ->with($credentials, false)
            ->once()
            ->andReturn(true);

        $this->assertTrue(
            $this->app->make(AuthenticateUser::class, [
                'guard' => $guard,
            ])->authenticate(Request::create('/', 'POST', $credentials))
        );
    }
}
