<?php

namespace Tests\Feature\CustomerExperience;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;

class ViewSpacesListingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $_SERVER['REMOTE_ADDR'] = '122.255.0.0';
    }

    protected function tearDown(): void
    {
        cache()->flush();

        unset($_SERVER['HTTP_CLIENT_IP'], $_SERVER['HTTP_X_FORWARDED_FOR'], $_SERVER['REMOTE_ADDR']);

        $_SERVER['HTTP_CLIENT_IP'] = null;
        $_SERVER['HTTP_X_FORWARDED_FOR'] = null;
        $_SERVER['REMOTE_ADDR'] = null;
    }

    /** @test */
    public function user_can_view_all_available_spaces_in_listing()
    {
        $space = create(Space::class);

        $this->get('/')
            ->assertStatus(200)
            ->assertSee($space->code);
    }

    /** @test */
    public function user_cannot_view_unavailable_spaces_in_listing()
    {
        $expiredSpace = create(Space::class, ['departs_at' => Carbon::now()->subMonth()]);
        $orderedSpace = create(Space::class, ['reserved_at' => now()]);
        $this->calculateCharges($orderedSpace);
        create(Order::class, ['space_id' => $orderedSpace->id]);
        $availableSpace = create(Space::class);

        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee($expiredSpace->code)
            ->assertDontSee($orderedSpace->code)
            ->assertSee($availableSpace->code);
    }
}
