<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Events\BusinessInvited;
use App\Mail\BusinessInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InviteBusinessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->signInAsAdmin();
    }

    public function testOnlyAdminCanInviteBusiness()
    {
        $user = User::factory()->asBusiness()->create([
            'locked' => true,
        ]);

        $this->signIn($user);

        $response = $this->post("/businesses/invitations/{$user->username}");

        $response->assertStatus(403);
    }

    public function testBusinessUserCanBeInvited()
    {
        Queue::fake();

        $user = User::factory()->asBusiness()->create([
            'locked' => true,
        ]);

        $this->admin->setResponsibility($user);

        $response = $this->post("/businesses/invitations/{$user->username}");

        $response->assertStatus(303);
    }

    public function testBusinessUserCanBeInvitedThroughJsonRequest()
    {
        Queue::fake();

        $user = User::factory()->asBusiness()->create([
            'locked' => true,
        ]);

        $this->admin->setResponsibility($user);

        $response = $this->postJson("/businesses/invitations/{$user->username}");

        $response->assertStatus(201);
    }

    public function testPreviouslyInvitedUserCannotBeInvited()
    {
        Queue::fake();

        $user = User::factory()->asBusiness()->create([
            'locked' => true,
        ]);

        $user->invite();

        $this->admin->setResponsibility($user);

        $response = $this->post("/businesses/invitations/{$user->username}");

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function testInvitationEmailIsSentToUser()
    {
        $this->withoutEvents();

        Mail::fake();

        $user = User::factory()->asBusiness()->create([
            'locked' => true,
        ]);

        $this->admin->setResponsibility($user);

        $response = $this->post("/businesses/invitations/{$user->username}");

        Mail::assertQueued(function (BusinessInvitation $mail) use ($user) {
            return $mail->invitation()->user->is($user) &&
                $mail->hasTo($user->email);
        });

        $response->assertStatus(303);
    }

    public function testInvitationSentEventIsDispatched()
    {
        Mail::fake();
        Event::fake([BusinessInvited::class]);

        $user = User::factory()->asBusiness()->create([
            'locked' => true,
        ]);

        $this->admin->setResponsibility($user);

        $response = $this->post("/businesses/invitations/{$user->username}");

        Event::assertDispatched(BusinessInvited::class);

        $response->assertStatus(303);
    }

    protected function signInAsAdmin()
    {
        $admin = create(User::class);

        $admin->assignRole(
            Role::create([
                'name' => 'Administrator',
                'slug' => 'administrator',
            ])
        );

        $this->signIn($admin);

        return $admin;
    }
}
