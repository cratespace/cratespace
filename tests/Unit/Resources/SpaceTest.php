<?php

namespace Tests\Unit\Resources;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use Illuminate\Support\Str;
use App\Filters\SpaceFilter;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SpaceTest extends TestCase
{
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
    public function it_has_a_listing_feature()
    {
        $spaces = create(Space::class, [], 100);
        $expiredSpaces = create(Space::class, ['status' => 'Expired'], 2);

        $this->assertCount(100, Space::list()->get());
        $this->assertEquals('Available', Space::list()->first()->status);
        $this->assertInstanceOf(LengthAwarePaginator::class, Space::list()->paginate());

        $spaces = $spaces->merge($expiredSpaces);

        foreach ($spaces as $space) {
            if ($space->status === 'Available') {
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

        $this->assertTrue($availableSpace->isAvailable());
        $this->assertFalse($expiredSpace->isAvailable());
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
    public function it_can_place_an_order_for_itself()
    {
        $space = create(Space::class);
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

        $orderedSpace = create(Space::class, ['status' => 'Ordered']);
        $orderedSpace->placeOrder(['email' => 'john@example.com']);

        $expiredSpace = create(Space::class, ['status' => 'Expired']);
        $expiredSpace->placeOrder(['email' => 'john@example.com']);
    }

    /** @test */
    public function it_can_save_departure_and_arrival_date_strings_as_datetime()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(Carbon::class, $space->departs_at);
        $this->assertInstanceOf(Carbon::class, $space->arrives_at);
    }

    /** @test */
    public function it_can_be_marked_as_given_status()
    {
        $space = create(Space::class);

        $this->assertEquals('Available', $space->status);

        $space->markAs('Ordered');

        $this->assertEquals('Ordered', $space->status);

        $space->markAs('Expired');

        $this->assertEquals('Expired', $space->status);
    }

    /** @test */
    public function it_can_be_filtered_by_type()
    {
        $localSpace = create(Space::class, ['type' => 'Local']);
        $internationalSpace = create(Space::class, ['type' => 'International']);

        $requestForLocalSpace = Request::create('/', 'GET', ['type' => 'Local']);
        $requestForInternationalSpace = Request::create('/', 'GET', ['type' => 'International']);

        $localSpaceFilters = new SpaceFilter($requestForLocalSpace);
        $internationalSpaceFilters = new SpaceFilter($requestForInternationalSpace);

        $filteredLocalSpace = Space::filter($localSpaceFilters)->first();
        $filteredInternationalSpace = Space::filter($internationalSpaceFilters)->first();

        $this->assertTrue($localSpace->is($filteredLocalSpace));
        $this->assertTrue($internationalSpace->is($filteredInternationalSpace));
    }

    /** @test */
    public function it_can_be_filtered_by_status()
    {
        $availableSpace = create(Space::class, ['status' => 'Available']);
        $orderedSpace = create(Space::class, ['status' => 'Ordered']);

        $requestForAvailableSpace = Request::create('/', 'GET', ['status' => 'Available']);
        $requestForOrderedSpace = Request::create('/', 'GET', ['status' => 'Ordered']);

        $availableSpaceFilters = new SpaceFilter($requestForAvailableSpace);
        $orderedSpaceFilters = new SpaceFilter($requestForOrderedSpace);

        $filteredAvailableSpace = Space::filter($availableSpaceFilters)->first();
        $filteredOrderedSpace = Space::filter($orderedSpaceFilters)->first();

        $this->assertTrue($availableSpace->is($filteredAvailableSpace));
        $this->assertTrue($orderedSpace->is($filteredOrderedSpace));
    }

    /** @test */
    public function it_can_be_filtered_by_origin_and_detination()
    {
        $spaceFromTrinco = create(Space::class, ['origin' => 'Trinco']);
        $spaceFromColombo = create(Space::class, ['origin' => 'Colombo']);
        $spaceToTrinco = create(Space::class, ['destination' => 'Trinco']);
        $spaceToColombo = create(Space::class, ['destination' => 'Colombo']);

        $requestForSpaceFromTrinco = Request::create('/', 'GET', ['origin' => 'Trinco']);
        $requestForSpaceFromColombo = Request::create('/', 'GET', ['origin' => 'Colombo']);
        $requestForSpaceToTrinco = Request::create('/', 'GET', ['destination' => 'Trinco']);
        $requestForSpaceToColombo = Request::create('/', 'GET', ['destination' => 'Colombo']);

        $fromTrincoSpaceFilters = new SpaceFilter($requestForSpaceFromTrinco);
        $fromColomboSpaceFilters = new SpaceFilter($requestForSpaceFromColombo);
        $toTrincoSpaceFilters = new SpaceFilter($requestForSpaceToTrinco);
        $toColomboSpaceFilters = new SpaceFilter($requestForSpaceToColombo);

        $filteredSpaceFromTrinco = Space::filter($fromTrincoSpaceFilters)->first();
        $filteredSpaceFromColombo = Space::filter($fromColomboSpaceFilters)->first();
        $filteredSpaceToTrinco = Space::filter($toTrincoSpaceFilters)->first();
        $filteredSpaceToColombo = Space::filter($toColomboSpaceFilters)->first();

        $this->assertTrue($spaceFromTrinco->is($filteredSpaceFromTrinco));
        $this->assertTrue($spaceFromColombo->is($filteredSpaceFromColombo));
        $this->assertTrue($spaceToTrinco->is($filteredSpaceToTrinco));
        $this->assertTrue($spaceToColombo->is($filteredSpaceToColombo));
    }
}
