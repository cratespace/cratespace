<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Tests\Contracts\Postable;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewUserTest extends TestCase implements Postable
{
    use RefreshDatabase;

    /** @test */
    public function only_guests_can_create_new_accounts()
    {
        $user = create(User::class);

        $this->actingAs($user)
            ->post('/register', $this->validParameters())
            ->assertStatus(302)
            ->assertRedirect('/home');
    }

    /** @test */
    public function an_event_is_dispatched_after_new_user_has_been_successfully_created()
    {
        Event::fake([Registered::class]);

        $this->post('/register', $this->validParameters())->assertRedirect('/home');

        Event::assertDispatched(Registered::class);
    }

    /** @test */
    public function verification_notification_is_sent_after_new_user_has_been_successfully_created()
    {
        Notification::fake();

        Notification::assertNothingSent();

        $this->post('/register', $this->validParameters())->assertRedirect('/home');

        Notification::assertSentTo([auth()->user()], VerifyEmail::class);
    }

    /** @test */
    public function a_username_is_generated_for_every_new_user()
    {
        $this->post('/register', $this->validParameters())
            ->assertStatus(302)
            ->assertRedirect('/home');

        $username = auth()->user()->getAttribute('username');
        $this->assertTrue(is_string($username));
        $this->assertDatabaseHas('users', ['username' => $username]);
    }

    /** @test */
    public function a_valid_name_is_required()
    {
        $response = $this->post('/register', $this->validParameters([
            'name' => '',
        ]));

        $response->assertStatus(302)->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_valid_email_is_required()
    {
        $response = $this->post('/register', $this->validParameters([
            'email' => '',
        ]));

        $response->assertStatus(302)->assertSessionHasErrors('email');
    }

    /** @test */
    public function a_valid_business_name_is_required()
    {
        $response = $this->post('/register', $this->validParameters([
            'business' => '',
        ]));

        $response->assertStatus(302)->assertSessionHasErrors('business');
    }

    /** @test */
    public function a_valid_phone_number_is_required()
    {
        $response = $this->post('/register', $this->validParameters([
            'phone' => '',
        ]));

        $response->assertStatus(302)->assertSessionHasErrors('phone');
    }

    /** @test */
    public function a_valid_password_is_required()
    {
        $response = $this->post('/register', $this->validParameters([
            'password' => '',
        ]));

        $response->assertStatus(302)->assertSessionHasErrors('password');
    }

    /** @test */
    public function password_must_be_confirmed()
    {
        $response = $this->post('/register', $this->validParameters([
            'password_confirmation' => '',
        ]));

        $response->assertStatus(302)->assertSessionHasErrors('password');
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
            'business' => $this->faker->company,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'password' => 'battleCattle',
            'password_confirmation' => 'battleCattle',
        ], $overrides);
    }
}
