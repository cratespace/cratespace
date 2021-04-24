<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Jobs\InviteBusiness;
use Tests\Contracts\Postable;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewBusinessTest extends TestCase implements Postable
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up Administrator role.
        Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        // Set up Business role.
        Role::create([
            'name' => 'Business',
            'slug' => 'business',
        ]);

        $user = create(User::class);
        $user->assignRole('Administrator');

        $this->signIn($user);
    }

    protected function tearDown(): void
    {
        auth()->logout();
    }

    public function testBusinessUserCanBeCreated()
    {
        $response = $this->post('/businesses', $this->validParameters());

        $response->assertStatus(303);
    }

    public function testBusinessUserCanBeCreatedAndInvited()
    {
        Queue::fake();

        $response = $this->post('/businesses', $this->validParameters([
            'invite' => true,
        ]));

        Queue::assertPushed(InviteBusiness::class);

        $response->assertStatus(303);
    }

    public function testOnlyBusinessUserCanBeInvited()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'invite' => true,
            'type' => 'customer',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('type');
    }

    public function testNameFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'name' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }

    public function testEmailFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'email' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function testBusinessFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'business' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('business');
    }

    public function testPhoneFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'phone' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('phone');
    }

    public function testTypeFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'type' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('type');
    }

    public function testPasswordFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'password' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('password');
    }

    public function testStreetFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'line1' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('line1');
    }

    public function testCityFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'city' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('city');
    }

    public function testStateFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'state' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('state');
    }

    public function testCountryFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'country' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('country');
    }

    public function testPostalcodeFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'postal_code' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('postal_code');
    }

    public function testRegistrationNumberFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'registration_number' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('registration_number');
    }

    public function testMCCFieldIsRequired()
    {
        $response = $this->post('/businesses', $this->validParameters([
            'mcc' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('mcc');
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
            'business' => 'Parochial House',
            'name' => 'Father Jack Hackett',
            'email' => 'fr.j.hackett@craggyisle.com',
            'phone' => '0712345678',
            'password' => 'dontTellMeImStillInThatFekingIsland',
            'password_confirmation' => 'dontTellMeImStillInThatFekingIsland',
            'type' => 'business',
            'line1' => 'Glenquin',
            'city' => 'Killinaboy',
            'state' => 'Munster',
            'country' => 'Ireland',
            'postal_code' => '48161',
            'registration_number' => '01234567',
            'mcc' => '4798',
            'invite' => false,
            'type' => 'business',
        ], $overrides);
    }
}
