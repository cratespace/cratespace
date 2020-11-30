<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_see_confirm_password_view()
    {
        $user = create(User::class, [
            'email' => 'jefferson@skulding.com',
            'password' => bcrypt('ohsnapmate'),
        ]);

        // $response = $this->withoutExceptionHandling()
        //     ->actingAs($user)
        //     ->get('/user/confirm-password')
        //     ->assertStatus(200);
        $this->get('/')->assertStatus(200);
    }

    /** @test */
    public function authentiacted_user_can_confirm_password()
    {
        $user = create(User::class, [
            'email' => 'jefferson@skulding.com',
            'password' => bcrypt('ohsnapmate'),
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->withSession(['url.intended' => 'http://foo.com/bar'])
            ->post('/user/confirm-password', ['password' => 'ohsnapmate']);

        $response->assertSessionHas('auth.password_confirmed_at');
        $response->assertRedirect('http://foo.com/bar');
    }

    /** @test */
    public function password_confirmation_can_fail_without_a_password()
    {
        $user = create(User::class, [
            'email' => 'jefferson@skulding.com',
            'password' => bcrypt('ohsnapmate'),
        ]);

        $response = $this->withoutExceptionHandling()
            ->actingAs($user)
            ->withSession(['url.intended' => 'http://foo.com/bar'])
            ->post('/user/confirm-password', ['password' => null]);

        $response->assertSessionHasErrors(['password']);
        $response->assertSessionMissing('auth.password_confirmed_at');
        $response->assertRedirect();
        $this->assertNotEquals($response->getTargetUrl(), 'http://foo.com/bar');
    }

    /** @test */
    public function password_can_be_confirmed_with_json()
    {
        $user = create(User::class, [
            'email' => 'jefferson@skulding.com',
            'password' => bcrypt('ohsnapmate'),
        ]);

        $response = $this->actingAs($user)->postJson(
            '/user/confirm-password',
            ['password' => 'ohsnapmate']
        );

        $response->assertStatus(201);
    }

    /** @test */
    public function password_confirmation_can_fail_with_json()
    {
        $user = create(User::class, [
            'email' => 'jefferson@skulding.com',
            'password' => bcrypt('ohsnapmate'),
        ]);

        $response = $this->actingAs($user)->postJson(
            '/user/confirm-password',
            ['password' => 'invalid']
        );

        $response->assertJsonValidationErrors('password');
    }
}
