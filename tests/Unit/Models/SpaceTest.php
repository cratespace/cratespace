<?php

namespace Tests\Unit\Models;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use App\Models\Values\Schedule;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceTest extends TestCase
{
    use RefreshDatabase;

    public function testUniqueCodeIsGeneratedOnModelCreate()
    {
        $space = create(Space::class, ['code' => '']);

        $entity = Space::find($space->id);

        $this->assertFalse(empty($entity->code));
        $this->assertIsString($entity->code);
    }

    public function testItBelongsToAUser()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(User::class, $space->owner);
    }

    public function testItHasACountryWhereItIsBasedIn()
    {
        $space = create(Space::class);

        $this->assertEquals($space->owner->address->country, $space->base);
    }

    public function testItHasASetOfRequiredAttributes()
    {
        $space = create(Space::class);

        $this->assertDatabaseHas('spaces', [
            'code' => $space->code,
            'reserved_at' => null,
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
            'base' => $space->base,
            'note' => $space->note,
        ]);
    }

    public function testItCanCastDepartureAndArrivalDatesAsCarbonInstances()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(Carbon::class, $space->departs_at);
        $this->assertInstanceOf(Carbon::class, $space->arrives_at);
        $this->assertInstanceOf(Schedule::class, $space->schedule);
    }

    public function testItCanCreateAScheduleValueObjectOfGivenDates()
    {
        $space = create(Space::class);

        $this->assertEquals($space->departs_at->format('M j, Y g:ia'), $space->schedule->departsAt);
        $this->assertEquals($space->arrives_at->format('M j, Y g:ia'), $space->schedule->arrivesAt);
    }

    public function testItCanDetermineItsDepartureDate()
    {
        $space = create(Space::class, [
            'departs_at' => Carbon::tomorrow(),
        ]);

        $this->assertTrue($space->schedule->nearingDeparture());
    }

    public function testItCanPresentTotalPrice()
    {
        $space = create(Space::class, ['price' => 900, 'tax' => 100]);

        $this->assertEquals('$10.00', $space->present()->price);
    }

    public function testDetermineReservedStatus()
    {
        $space = create(Space::class, [
            'reserved_at' => now(),
        ]);

        $this->assertTrue($space->reserved());
    }

    public function testReserveAndRelease()
    {
        Event::fake();

        $space = create(Space::class);

        $space->reserve();
        $this->assertNotNull($space->fresh()->reserved_at);

        $space->release();
        $this->assertNull($space->fresh()->reserved_at);
    }
}
