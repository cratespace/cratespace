<?php

namespace Tests\Feature\BusinessUserExperience;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserLoginTest extends TestCase
{
    /** @test */
    public function logging_in_with_valid_credentials()
    {
        $this->withoutExceptionHandling();

        $user = create(User::class, [
            'email' => 'john@doe.com',
            'password' => Hash::make('supersecretpassword'),
        ]);

        $response = $this->post('/login', [
            'email' => 'john@doe.com',
            'password' => 'supersecretpassword',
        ]);

        $this->assertTrue(Auth::check());
        $this->assertTrue(Auth::user()->is($user));
        $response->assertRedirect('/home');
    }

    /** @test */
    public function logging_in_with_invalid_credentials()
    {
        $user = create(User::class, [
            'email' => 'john@doe.com',
            'password' => Hash::make('supersecretpassword'),
        ]);

        $this->get('/login');

        $response = $this->post('/login', [
            'email' => 'john@doe.com',
            'password' => 'notsupersecretpassword',
        ]);

        $this->assertFalse(Auth::check());
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function logging_in_with_an_account_that_does_not_exist()
    {
        $this->get('/login');

        $response = $this->post('/login', [
            'email' => 'john@doe.com',
            'password' => 'notsupersecretpassword',
        ]);

        $this->assertFalse(Auth::check());
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
    }
}
