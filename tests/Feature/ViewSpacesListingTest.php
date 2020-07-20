<?php

namespace Tests\Feature;

use Carbon\Carbon;
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
        $expiredSpace = create(Space::class, ['departs_at' => Carbon::now()->subMonth()]);
        $orderedSpace = create(Space::class);
        $orderedSpace->placeOrder([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);
        $availableSpace = create(Space::class);

        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee($expiredSpace->uid)
            ->assertDontSee($orderedSpace->uid)
            ->assertSee($availableSpace->uid);
    }
}
