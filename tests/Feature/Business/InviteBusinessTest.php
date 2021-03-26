<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\User;
use Cratespace\Preflight\Models\Role;
use Illuminate\Support\Facades\Queue;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class InviteBusinessTest extends TestCase implements Postable
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
        app(StatefulGuard::class)->logout();
    }

    public function testABusinessUserCanBeInvited()
    {
        Queue::fake();

        $user = User::factory()->asBusiness()->create();

        $response = $this->post(
            "/businesses/invite/{$user->username}",
            $this->validParameters(['email' => $user->email])
        );

        $response->assertStatus(303);
    }

    public function testRoleFieldIsRequired()
    {
        $user = User::factory()->asBusiness()->create();

        $response = $this->post(
            "/businesses/invite/{$user->username}",
            $this->validParameters([
                'email' => $user->email,
                'role' => '',
            ])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('role');
    }

    public function testEmailFieldIsRequired()
    {
        $user = User::factory()->asBusiness()->create();

        $response = $this->post(
            "/businesses/invite/{$user->username}",
            $this->validParameters(['email' => ''])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function testInvitedUsersCannotBeInvitedANew()
    {
        $user = User::factory()->asBusiness()->create();
        $user->invite();

        $this->assertTrue($user->invited());

        $response = $this->post(
            "/businesses/invite/{$user->username}",
            $this->validParameters(['email' => $user->email])
        );

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
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
            'role' => 'Business',
        ], $overrides);
    }
}
