<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testTheConfirmPasswordViewIsReturned()
    {
        $user = create(User::class, $credentials = [
            'password' => Hash::make('cthuluEmployee'),
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->get('/user/confirm-password');

        $response->assertStatus(200);
    }

    public function testPasswordCanBeConfirmed()
    {
        $user = create(User::class, $credentials = [
            'password' => Hash::make('cthuluEmployee'),
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->withSession(['url.intended' => 'http://foo.com/bar'])
            ->post('/user/confirm-password', ['password' => 'cthuluEmployee']);

        $response->assertSessionHas('auth.password_confirmed_at');
        $response->assertRedirect('http://foo.com/bar');
    }

    public function testPasswordConfirmationCanFailWithAnInvalidPassword()
    {
        $user = create(User::class, $credentials = [
            'password' => Hash::make('cthuluEmployee'),
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->withSession(['url.intended' => 'http://foo.com/bar'])
            ->post('/user/confirm-password', ['password' => 'invalid']);

        $response->assertSessionHasErrors(['password']);
        $response->assertSessionMissing('auth.password_confirmed_at');
        $response->assertRedirect();
        $this->assertNotEquals($response->getTargetUrl(), 'http://foo.com/bar');
    }

    public function testPasswordConfirmationCanFailWithoutAPassword()
    {
        $user = create(User::class, $credentials = [
            'password' => Hash::make('cthuluEmployee'),
        ]);

        $response = $this->actingAs($user)
            ->withSession(['url.intended' => 'http://foo.com/bar'])
            ->post('/user/confirm-password', ['password' => null]);

        $response->assertSessionHasErrors(['password']);
        $response->assertSessionMissing('auth.password_confirmed_at');
        $response->assertRedirect();
        $this->assertNotEquals($response->getTargetUrl(), 'http://foo.com/bar');
    }

    public function testPasswordCanBeConfirmedWithJson()
    {
        $user = create(User::class, $credentials = [
            'password' => Hash::make('cthuluEmployee'),
        ]);

        $response = $this->actingAs($user)
            ->postJson('/user/confirm-password', ['password' => 'cthuluEmployee']);

        $response->assertStatus(201);
    }

    public function testPasswordConfirmationCanFailWithJson()
    {
        $user = create(User::class, $credentials = [
            'password' => Hash::make('cthuluEmployee'),
        ]);

        $response = $this->actingAs($user)
            ->postJson('/user/confirm-password', ['password' => 'invalid']);

        $response->assertJsonValidationErrors('password');
    }
}
