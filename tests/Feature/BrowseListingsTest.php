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
        unset($_SERVER['REMOTE_ADDR']);

        $spaceLanka = create(Space::class, ['base' => 'Sri Lanka']);
        $spaceUS = create(Space::class, ['base' => 'United States']);

        $this->get('/')
             ->assertStatus(200)
             ->assertDontSee($spaceUS->uid)
             ->assertSee($spaceLanka->uid);
    }

    /** @test */
    public function customers_can_sort_listings_according_to_origin_place()
    {
        $spaceFromColombo = create(Space::class, [
            'base' => 'Sri Lanka',
            'origin' => 'Colombo',
        ]);
        $spaceFromTrinco = create(Space::class, [
            'base' => 'Sri Lanka',
            'origin' => 'Trincomalee',
        ]);
        create(Space::class, ['base' => 'Sri Lanka'], 5);

        $this->get('/?origin=Colombo')
            ->assertSee($spaceFromColombo->uid)
            ->assertDontSee($spaceFromTrinco->uid);
    }

    /** @test */
    public function customers_can_sort_listings_according_to_destination_place()
    {
        $spaceToColombo = create(Space::class, [
            'base' => 'Sri Lanka',
            'destination' => 'Colombo',
        ]);
        $spaceToTrinco = create(Space::class, [
            'base' => 'Sri Lanka',
            'destination' => 'Trincomalee',
        ]);
        create(Space::class, ['base' => 'Sri Lanka'], 5);

        $this->get('/?destination=Colombo')
            ->assertSee($spaceToColombo->uid)
            ->assertDontSee($spaceToTrinco->uid);
    }

    /** @test */
    public function customers_can_sort_listings_according_to_departure_date()
    {
        $desiredDate = now();

        $desiredSpace = create(Space::class, [
            'base' => 'Sri Lanka',
            'departs_at' => $desiredDate,
        ]);
        $undesiredSpace = create(Space::class, [
            'base' => 'Sri Lanka',
            'departs_at' => now()->addDay(),
        ]);
        create(Space::class, ['base' => 'Sri Lanka'], 5);

        $this->get('/?departs_at=' . $desiredDate->format('Y-m-d'))
            ->assertSee($desiredSpace->uid)
            ->assertDontSee($undesiredSpace->uid);
    }

    /** @test */
    public function customers_can_sort_listings_according_to_arrival_date()
    {
        $desiredDate = now();

        $desiredSpace = create(Space::class, [
            'base' => 'Sri Lanka',
            'arrives_at' => $desiredDate,
        ]);
        $undesiredSpace = create(Space::class, [
            'base' => 'Sri Lanka',
            'arrives_at' => now()->addDay(),
        ]);
        create(Space::class, ['base' => 'Sri Lanka'], 5);

        $this->get('/?arrives_at=' . $desiredDate->format('Y-m-d'))
            ->assertSee($desiredSpace->uid)
            ->assertDontSee($undesiredSpace->uid);
    }
}
