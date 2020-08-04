<?php

namespace Tests\Unit\Resources;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use App\Billing\Calculator;
use Illuminate\Support\Str;
use App\Models\Values\ScheduleValue;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SpaceTest extends TestCase
{
    protected function tearDown(): void
    {
        cache()->flush();
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(User::class, $space->user);
    }

    /** @test */
    public function it_has_a_specific_path()
    {
        $space1 = create(Space::class);
        $space2 = create(Space::class);

        $this->assertNotEquals($space1, $space2);
        $this->assertNotEquals($space1->path, $space2->path);
        $this->assertTrue(is_string($space1->path));
    }

    /** @test */
    public function it_has_a_schedule()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(ScheduleValue::class, $space->schedule);
        $this->assertEquals($space->schedule->departsAt, $space->departs_at->format('M j, Y'));
        $this->assertEquals($space->schedule->arrivesAt, $space->arrives_at->format('M j, Y'));
    }

    /** @test */
    public function it_can_determine_its_departure_date()
    {
        $space = create(Space::class, [
            'departs_at' => Carbon::tomorrow(),
        ]);

        $this->assertTrue($space->schedule->nearingDeparture());
    }

    /** @test */
    public function it_can_get_the_name_of_the_business_it_belongs_to()
    {
        $space = create(Space::class);

        $this->assertTrue(is_string($space->businessname));
        $this->assertEquals($space->businessname, $space->user->business->name);
    }

    /** @test */
    public function it_has_a_listing_feature()
    {
        $spaces = create(Space::class, [], 100);
        $expiredSpaces = create(Space::class, [
            'departs_at' => Carbon::now()->subMonth(),
        ], 2);

        $this->assertCount(100, Space::list()->get());
        $this->assertEquals('Available', Space::list()->first()->status);
        $this->assertInstanceOf(LengthAwarePaginator::class, Space::list()->paginate());

        $spaces = $spaces->merge($expiredSpaces);

        foreach ($spaces as $space) {
            if ($space->isAvailable()) {
                $this->assertTrue(Space::list()->get()->contains($space));
            } else {
                $this->assertFalse(Space::list()->get()->contains($space));
            }
        }
    }

    /** @test */
    public function listing_feature_can_get_business_name_but_only_the_name()
    {
        $space = create(Space::class);

        $this->assertEquals($space->user->business->name, Space::list()->first()->business);
    }

    /** @test */
    public function it_can_dynamically_calculate_its_dimensions()
    {
        $space = create(Space::class);

        $volume = $space->height * $space->width * $space->length;

        $this->assertEquals($volume, $space->present()->volume);
    }

    /** @test */
    public function it_can_determine_its_availability()
    {
        $availableSpace = create(Space::class);
        $expiredSpace = create(Space::class, ['departs_at' => Carbon::now()->subMonth()]);
        $orderedSpace = create(Space::class);
        $this->calculateCharges($orderedSpace);
        $order = $orderedSpace->placeOrder([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);

        $this->assertTrue($availableSpace->isAvailable());
        $this->assertFalse($expiredSpace->isAvailable());
        $this->assertTrue($expiredSpace->isExpired());
        $this->assertFalse($orderedSpace->isAvailable());
        $this->assertTrue($orderedSpace->hasOrder());
    }

    /** @test */
    public function it_can_get_price_in_dollars()
    {
        $space = create(Space::class, ['price' => 10.67]);

        $this->assertDataBaseHas('spaces', ['price' => 1067]);

        $this->assertTrue(is_string($space->price));
        $this->assertTrue(Str::contains($space->price, '$'));
        $this->assertEquals('$10.67', $space->price);
    }

    /** @test */
    public function it_can_get_price_in_cents()
    {
        $space = create(Space::class, ['price' => 10.67]);

        $this->assertDataBaseHas('spaces', ['price' => 1067]);

        $this->assertTrue(is_string($space->price));
        $this->assertTrue(is_integer($space->getPriceInCents()));
        $this->assertEquals(1067, $space->getPriceInCents());
    }

    /** @test */
    public function it_can_get_tax_in_dollars()
    {
        $space = create(Space::class, ['tax' => 10.67]);

        $this->assertDataBaseHas('spaces', ['tax' => 1067]);

        $this->assertTrue(is_string($space->tax));
        $this->assertTrue(Str::contains($space->tax, '$'));
        $this->assertEquals('$10.67', $space->tax);
    }

    /** @test */
    public function it_can_get_tax_in_cents()
    {
        $space = create(Space::class, ['tax' => 10.67]);

        $this->assertDataBaseHas('spaces', ['tax' => 1067]);

        $this->assertTrue(is_string($space->tax));
        $this->assertTrue(is_integer($space->getTaxInCents()));
        $this->assertEquals(1067, $space->getTaxInCents());
    }

    /** @test */
    public function it_can_release_it_self_from_an_order()
    {
        $space = create(Space::class);
        $this->calculateCharges($space);
        $space->placeOrder(make(Order::class)->toArray());

        $this->assertEquals('Ordered', $space->status);

        $space->order()->delete();

        $this->assertEquals('Available', $space->refresh()->status);
    }

    /** @test */
    public function it_can_place_an_order_for_itself()
    {
        $space = create(Space::class);
        $this->calculateCharges($space);
        $space->placeOrder([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);

        $this->assertNotNull($space->order);
        $this->assertInstanceOf(Order::class, $space->order);
        $this->assertEquals('john@example.com', $space->order->email);
    }

    /** @test */
    public function it_can_place_an_order_for_itself_only_if_it_is_available()
    {
        $this->expectException(HttpException::class);

        $orderedSpace = create(Space::class);
        $this->calculateCharges($orderedSpace);
        $orderedSpace->placeOrder(make(Order::class)->toArray());

        $expiredSpace = create(Space::class, ['departs_at' => Carbon::now()->subMonth()]);
        $expiredSpace->placeOrder(make(Order::class)->toArray());
    }

    /** @test */
    public function it_can_save_departure_and_arrival_date_strings_as_datetime()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(Carbon::class, $space->departs_at);
        $this->assertInstanceOf(Carbon::class, $space->arrives_at);
    }

    /** @test */
    public function it_can_be_released_from_an_order_if_the_order_fails()
    {
        $space = create(Space::class);

        $this->assertEquals('Available', $space->status);

        $this->calculateCharges($space);

        $order = $space->placeOrder([
            'name' => 'John Doe',
            'business' => 'Example, Co.',
            'phone' => '765487368',
            'email' => 'john@example.com',
        ]);

        $this->assertEquals('Ordered', $space->status);

        $order->delete();

        $this->assertNull($space->order);
        $this->assertTrue($space->isAvailable());
    }

    /**
     * Calculate amount to be charged to customer.
     *
     * @param \App\Models\Space $space
     *
     * @return void
     */
    protected function calculateCharges(Space $space): void
    {
        $chargesCalculator = new Calculator($space);

        $chargesCalculator->calculateCharges();
    }
}
