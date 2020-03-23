<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Space;
use Stevebauman\Location\Facades\Location;

class BrowseListingsTest extends TestCase
{
    /** @test */
    public function customers_can_view_all_listings_based_on_their_location()
    {
        $_SERVER['REMOTE_ADDR'] = '66.102.0.0';

        $space = create(Space::class, ['base' => 'United States']);

        $this->get('/')
             ->assertStatus(200)
             ->assertSee($space->uid);
    }

    /** @test */
    public function customers_will_see_listings_of_sri_lanka_if_ip_cannot_be_identified()
    {
        $_SERVER['REMOTE_ADDR'] = null;

        $spaceLanka = create(Space::class, ['base' => 'Sri Lanka']);
        $spaceUS = create(Space::class, ['base' => 'United States']);

        $this->get('/')
             ->assertStatus(200)
             ->assertDontSee($spaceUS->uid)
             ->assertSee($spaceLanka->uid);
    }
}
