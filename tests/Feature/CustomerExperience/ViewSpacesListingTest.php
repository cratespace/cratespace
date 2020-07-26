<?php

namespace Tests\Feature\CustomerExperience;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Billing\Charges\Calculator;

class ViewSpacesListingTest extends TestCase
{
    protected function tearDown(): void
    {
        cache()->flush();
    }

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
        $chargesCalculator = new Calculator($orderedSpace);
        $chargesCalculator->calculateCharges();
        create(Order::class, ['space_id' => $orderedSpace->id]);
        $availableSpace = create(Space::class);

        $this->get('/')
            ->assertStatus(200)
            ->assertDontSee($expiredSpace->uid)
            ->assertDontSee($orderedSpace->uid)
            ->assertSee($availableSpace->uid);
    }
}
