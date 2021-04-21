<?php

namespace Tests\Feature\Auth;

use Mockery as m;
use Tests\TestCase;
use Tests\Contracts\Postable;
use Tests\Concerns\CreatesDefaultUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessRegistrationTest extends TestCase implements Postable
{
    use RefreshDatabase;
    use CreatesDefaultUser;

    protected function tearDown(): void
    {
        m::close();
    }

    public function testRegistrationView()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testNewCustomerCanRegister()
    {
        $this->withoutExceptionHandling();

        $user = m::mock(User::class);
        $user->shouldReceive('getAuthIdentifier')
            ->andReturn('Father Jack Hackett');

        $this->mock(CreatesNewUsers::class)
            ->shouldReceive('create')
            ->andReturn($user);

        $this->createDefaults();

        $response = $this->post('/register', $this->validParameters());

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function testNewCustomerCanRegisterThroughJson()
    {
        $this->withoutExceptionHandling();

        $user = m::mock(User::class);
        $user->shouldReceive('getAuthIdentifier')
            ->andReturn('Father Jack Hackett');
        $user->shouldReceive('toJson')
            ->andReturn('');

        $this->mock(CreatesNewUsers::class)
            ->shouldReceive('create')
            ->andReturn($user);

        $this->createDefaults();

        $response = $this->postJson('/register', $this->validParameters());

        $this->assertAuthenticated();
        $response->assertStatus(201);
    }

    public function testCustomerUsersCanBeCreatedAndRedirectedToIntendedUrl()
    {
        $user = m::mock(User::class);
        $user->shouldReceive('getAuthIdentifier')
            ->andReturn('Father Jack Hackett');

        $this->mock(CreatesNewUsers::class)
            ->shouldReceive('create')
            ->andReturn($user);

        $this->createDefaults();

        $response = $this->withSession(['url.intended' => 'http://foo.com/bar'])
            ->post('/register', $this->validParameters());

        $response->assertRedirect('http://foo.com/bar');
    }

    public function testValidNameIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'name' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }

    public function testValidEmailIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'email' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function testValidPhoneIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'phone' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('phone');
    }

    public function testValidPasswordIsRequired()
    {
        $response = $this->post('/register', $this->validParameters([
            'password' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
    }

    /**
     * Provide only the necessary paramertes for a POST-able type request.
     *
     * @param array $overrides
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Father Jack Hackett',
            'email' => 'fr.j.hackett@craggyisle.com',
            'phone' => '0712345678',
            'password' => 'dontTellMeImStillInThatFekingIsland',
            'password_confirmation' => 'dontTellMeImStillInThatFekingIsland',
            'type' => 'customer',
        ], $overrides);
    }
}
