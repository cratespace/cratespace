<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Space;

class ManageSpacesTest extends TestCase
{
    /** @test */
    public function a_user_is_redirected_to_available_spaces_route()
    {
        $this->signIn();

        $this->get('/spaces')->assertRedirect('/spaces?status=Available');
    }

    /** @test */
    public function a_user_can_view_a_space()
    {
        $this->signIn();

        $space = create(Space::class, ['user_id' => user('id')]);

        $this->get($space->path())
             ->assertSee($space->uid)
             ->assertSee($space->height)
             ->assertSee($space->width)
             ->assertSee($space->length);
    }

    /** @test */
    public function a_user_can_filter_space_by_status()
    {
        $this->signIn();

        $orderedSpace = create(Space::class, ['status' => 'Ordered', 'user_id' => user('id')]);
        $availableSpace = create(Space::class, ['status' => 'Available', 'user_id' => user('id')]);
        $expiredSpace = create(Space::class, ['status' => 'Expired', 'user_id' => user('id')]);
        $random = create(Space::class, ['user_id' => user('id')]);

        $this->getJson('/spaces?status='. $orderedSpace->status)
             ->assertStatus(200)
             ->assertSee($orderedSpace->uid);

        $this->getJson('/spaces?status='. $availableSpace->status)
             ->assertStatus(200)
             ->assertSee($availableSpace->uid);

        $this->getJson('/spaces?status='. $expiredSpace->status)
             ->assertStatus(200)
             ->assertSee($expiredSpace->uid);
    }

    /** @test */
    public function customers_cannot_view_a_single_space()
    {
        $space = create(Space::class);

        $this->get($space->path())
             ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_cannot_view_other_users_spaces()
    {
        $john = $this->signIn();
        $johnsSpace = create(Space::class, ['user_id' => $john->id]);

        $this->get($johnsSpace->path())
             ->assertStatus(200);

        auth()->logout();

        $james = $this->signIn();

        $this->get($johnsSpace->path())
             ->assertStatus(403);
    }
}
