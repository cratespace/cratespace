<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_see_the_register_view_is_returned()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_account_can_be_created()
    {
        $response = $this->post('/signup', [
            'name' => $this->faker->name,
            'business' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'password' => 'johnnyEnglish',
            'password_confirmation' => 'johnnyEnglish',
        ]);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
