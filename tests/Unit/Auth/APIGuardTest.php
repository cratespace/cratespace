<?php

namespace Tests\Unit\Auth;

use stdClass;
use Mockery as m;
use Tests\TestCase;
use App\Models\User;
use DateTimeInterface;
use Illuminate\Http\Request;
use App\Auth\Guards\APIGuard;
use App\API\Tokens\PersonalAccessToken;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class APIGuardTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        m::close();
    }

    public function testAuthenticationIsAttemptedWithWebMiddleware()
    {
        $factory = m::mock(AuthFactory::class);
        $guard = new APIGuard($factory, null, 'users');
        $webGuard = m::mock(stdClass::class);

        $factory->shouldReceive('guard')
            ->with('web')
            ->andReturn($webGuard);

        $webGuard->shouldReceive('user')->once()->andReturn(
            $fakeUser = new User()
        );

        $user = $guard->__invoke(Request::create('/', 'GET'));

        $this->assertSame($user, $fakeUser);
        $this->assertTrue($user->tokenCan('foo'));
    }

    public function testAuthenticationIsAttemptedWithTokenIfNoSessionPresent()
    {
        $factory = m::mock(AuthFactory::class);
        $guard = new APIGuard($factory, null, 'users');
        $webGuard = m::mock(stdClass::class);

        $factory->shouldReceive('guard')
            ->with('web')
            ->andReturn($webGuard);

        $webGuard->shouldReceive('user')->once()->andReturn(null);

        $request = Request::create('/', 'GET');
        $request->headers->set('Authorization', 'Bearer test');

        $user = $guard->__invoke($request);

        $this->assertNull($user);
    }

    public function testAuthenticationWithTokenFailsIfExpired()
    {
        $factory = m::mock(AuthFactory::class);
        $guard = new APIGuard($factory, 1, 'users');
        $webGuard = m::mock(stdClass::class);

        $factory->shouldReceive('guard')
            ->with('web')
            ->andReturn($webGuard);

        $webGuard->shouldReceive('user')->once()->andReturn(null);

        $request = Request::create('/', 'GET');
        $request->headers->set('Authorization', 'Bearer test');

        $user = create(User::class);

        $token = PersonalAccessToken::forceCreate([
            'tokenable_id' => $user->id,
            'tokenable_type' => get_class($user),
            'name' => 'Test',
            'token' => hash('sha256', 'test'),
            'created_at' => now()->subMinutes(60),
        ]);

        $user = $guard->__invoke($request);

        $this->assertNull($user);
    }

    public function testAuthenticationIsSuccessfulWithTokenIfNoSessionPresent()
    {
        $factory = m::mock(AuthFactory::class);
        $guard = new APIGuard($factory, null);
        $webGuard = m::mock(stdClass::class);

        $factory->shouldReceive('guard')
            ->with('web')
            ->andReturn($webGuard);

        $webGuard->shouldReceive('user')->once()->andReturn(null);

        $request = Request::create('/', 'GET');
        $request->headers->set('Authorization', 'Bearer test');

        $user = create(User::class);

        $token = PersonalAccessToken::forceCreate([
            'tokenable_id' => $user->id,
            'tokenable_type' => get_class($user),
            'name' => 'Test',
            'token' => hash('sha256', 'test'),
        ]);

        $returnedUser = $guard->__invoke($request);

        $this->assertEquals($user->id, $returnedUser->id);
        $this->assertEquals($token->id, $returnedUser->currentAccessToken()->id);
        $this->assertInstanceOf(DateTimeInterface::class, $returnedUser->currentAccessToken()->last_used_at);
    }

    public function testAuthenticationWithTokenFailsIfUserProviderIsInvalid()
    {
        config()->set('auth.guards.cratespace.provider', 'users');
        config()->set('auth.providers.users.model', 'App\Models\UserFake');

        $factory = $this->app->make(AuthFactory::class);
        $requestGuard = $factory->guard('cratespace');

        $request = Request::create('/', 'GET');
        $request->headers->set('Authorization', 'Bearer test');

        $user = create(User::class);

        $token = PersonalAccessToken::forceCreate([
            'tokenable_id' => $user->id,
            'tokenable_type' => get_class($user),
            'name' => 'Test',
            'token' => hash('sha256', 'test'),
        ]);

        $returnedUser = $requestGuard->setRequest($request)->user();

        $this->assertNull($returnedUser);
        $this->assertInstanceOf(EloquentUserProvider::class, $requestGuard->getProvider());
    }

    public function testAuthenticationIsSuccessfulWithTokenIfUserProviderIsValid()
    {
        config()->set('auth.guards.cratespace.provider', 'users');
        config()->set('auth.providers.users.model', User::class);

        $factory = $this->app->make(AuthFactory::class);
        $requestGuard = $factory->guard('cratespace');

        $request = Request::create('/', 'GET');
        $request->headers->set('Authorization', 'Bearer test');

        $user = create(User::class);

        $token = PersonalAccessToken::forceCreate([
            'tokenable_id' => $user->id,
            'tokenable_type' => get_class($user),
            'name' => 'Test',
            'token' => hash('sha256', 'test'),
        ]);

        $returnedUser = $requestGuard->setRequest($request)->user();

        $this->assertEquals($user->id, $returnedUser->id);
        $this->assertInstanceOf(EloquentUserProvider::class, $requestGuard->getProvider());
    }
}
