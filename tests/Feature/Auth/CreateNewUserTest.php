<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Tests\Contracts\Postable;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewUserTest extends TestCase implements Postable
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
        $response = $this->withoutExceptionHandling()
            ->post('/signup', $this->validParameters());

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test */
    public function a_valid_name_is_required()
    {
        $response = $this->from('/signup')
            ->post('/signup', $this->validParameters([
                'name' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/signup')
            ->assertSessionHasErrors('name');

        $this->assertEquals(0, User::count());
    }

    /** @test */
    public function a_valid_email_is_required()
    {
        $response = $this->from('/signup')
            ->post('/signup', $this->validParameters([
                'email' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/signup')
            ->assertSessionHasErrors('email');

        $this->assertEquals(0, User::count());
    }

    /** @test */
    public function a_valid_phone_is_required()
    {
        $response = $this->from('/signup')
            ->post('/signup', $this->validParameters([
                'phone' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/signup')
            ->assertSessionHasErrors('phone');

        $this->assertEquals(0, User::count());
    }

    /** @test */
    public function a_valid_business_is_required()
    {
        $response = $this->from('/signup')
            ->post('/signup', $this->validParameters([
                'business' => '',
            ]));

        $response->assertStatus(302)
            ->assertRedirect('/signup')
            ->assertSessionHasErrors('business');

        $this->assertEquals(0, User::count());
    }

    /**
     * Array of all valid parameters.
     *
     * @param array $override
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Eugene Krabs',
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'business' => $this->faker->company,
            'password' => 'SquidwardTetacles',
            'password_confirmation' => 'SquidwardTetacles',
        ], $overrides);
    }
}
