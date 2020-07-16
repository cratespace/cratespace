<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Space;

class ViewSpacesListingTest extends TestCase
{
    /** @test */
    public function user_can_view_all_available_spaces_in_listing()
    {
        $space = create(Space::class);

        $this->get('/')
            ->assertStatus(200)
            ->assertSee($space->uid);
    }

    /** @test */
    public function user_cannot_view_unavailable_spaces_in_listing()
    {
        $expiredSpace = create(Space::class, ['status' => 'Expired']);
        $orderedSpace = create(Space::class, ['status' => 'Ordered']);
        $availableSpace = create(Space::class);

        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee($expiredSpace->uid)
            ->assertDontSee($orderedSpace->uid)
            ->assertSee($availableSpace->uid);
    }
}
