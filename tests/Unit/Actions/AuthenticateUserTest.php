<?php

namespace Tests\Unit\Actions;

use Mockery as m;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use App\Actions\Auth\AuthenticateUser;

class AuthenticateUserTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testAuthenticateUser()
    {
        $credentials = [
            'email' => 'j.silver@man.com',
            'password' => 'getlostfool',
        ];

        $authenticator = m::mock(AuthenticateUser::class);
        $authenticator->shouldReceive('authenticate')
            ->once()
            ->with($request = Request::create('/', 'POST', $credentials))
            ->andReturn(true);

        $this->assertTrue($authenticator->authenticate($request));
    }
}
