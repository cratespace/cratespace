<?php

namespace Tests\Unit\Resources;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use App\Models\Values\ScheduleValue;

class SpaceTest extends TestCase
{
    /** @test */
    public function it_has_a_set_of_required_attributes()
    {
        $space = create(Space::class);

        $this->assertDatabaseHas('spaces', [
            'uid' => $space->uid,
            'departs_at' => $space->departs_at,
            'arrives_at' => $space->arrives_at,
            'origin' => $space->origin,
            'destination' => $space->destination,
            'height' => $space->height,
            'width' => $space->width,
            'length' => $space->length,
            'weight' => $space->weight,
            'price' => $space->price,
            'tax' => $space->tax,
            'user_id' => $space->user_id,
            'type' => $space->type,
        ]);
    }

    /** @test */
    public function it_can_cast_departure_and_arrival_dates_as_carbon_instances()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(Carbon::class, $space->departs_at);
        $this->assertInstanceOf(Carbon::class, $space->arrives_at);
        $this->assertInstanceOf(ScheduleValue::class, $space->schedule);
    }

    /** @test */
    public function it_can_cast_price_and_tax_attributes_as_cents_values()
    {
        $space = create(Space::class, [
            'price' => 12.35,
            'tax' => 0.35,
        ]);

        $this->assertEquals(1235, $space->price);
        $this->assertEquals(35, $space->tax);
    }

    /** @test */
    public function it_can_create_a_schedule_value_object_of_given_dates()
    {
        $space = create(Space::class);

        $this->assertEquals($space->departs_at->format('M j, Y g:ia'), $space->schedule->departsAt);
        $this->assertEquals($space->arrives_at->format('M j, Y g:ia'), $space->schedule->arrivesAt);
    }

    /** @test */
    public function it_belongs_to_a_business_user()
    {
        $user = create(User::class);
        $space = create(Space::class, ['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $space->user);
        $this->assertEquals($user->id, $space->user->id);
    }
}
