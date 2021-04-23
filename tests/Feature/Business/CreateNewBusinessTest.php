<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use Tests\Contracts\Postable;
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

    public function testBusinessUserCanBeCreatedThroughJsonRequest()
    {
        $response = $this->postJson('/businesses', $this->validParameters());

        $response->assertStatus(201);
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
        ], $overrides);
    }
}
