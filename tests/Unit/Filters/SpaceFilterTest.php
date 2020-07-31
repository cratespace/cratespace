<?php

namespace Tests\Unit\Filters;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Filters\Filter;
use App\Filters\SpaceFilter;
use Illuminate\Http\Request;

class SpaceFilterTest extends TestCase
{
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

    /** @test */
    public function it_can_be_filtered_by_departure_and_arrival_date()
    {
        $desiredDepartureDate = Carbon::now()->addDays(5);
        $desiredArrivalDate = Carbon::now()->addDays(7);

        $desiredDepartureSpace = create(Space::class, ['departs_at' => $desiredDepartureDate]);
        $unDesiredDepartureSpace = create(Space::class, ['departs_at' => Carbon::now()->addDays(3)]);
        $desiredArrivalSpace = create(Space::class, ['arrives_at' => $desiredArrivalDate]);
        $unDesiredArrivalSpace = create(Space::class, ['arrives_at' => Carbon::now()->addDays(5)]);

        $requestForSpacesDepartingAt = $this->makeRequest(['departs_at' => $desiredDepartureDate]);
        $requestForSpacesArrivingAt = $this->makeRequest(['arrives_at' => $desiredArrivalDate]);

        $desiredDepartureSpaceFilter = $this->getFilter($requestForSpacesDepartingAt);
        $desiredArrivalSpaceFilter = $this->getFilter($requestForSpacesArrivingAt);

        $filteredDesiredDepartureSpace = $this->filterSpaces($desiredDepartureSpaceFilter);
        $filteredDesiredArrivalSpace = $this->filterSpaces($desiredArrivalSpaceFilter);

        $this->assertTrue($desiredDepartureSpace->is($filteredDesiredDepartureSpace));
        $this->assertFalse($unDesiredDepartureSpace->is($filteredDesiredDepartureSpace));
        $this->assertTrue($desiredArrivalSpace->is($filteredDesiredArrivalSpace));
        $this->assertFalse($unDesiredArrivalSpace->is($filteredDesiredArrivalSpace));
    }

    /**
     * Make mock request to desired endpoint with given parameters.
     *
     * @param array $parameters
     *
     * @return \Illuminate\Http\Request
     */
    protected function makeRequest(array $parameters = [])
    {
        return Request::create('/', 'GET', $parameters);
    }

    /**
     * Get instance of space filter.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return App\Filters\SpaceFilter
     */
    protected function getFilter(Request $request)
    {
        return new SpaceFilter($request);
    }

    /**
     * Filter desired data.
     *
     * @param Filter $filters
     *
     * @return \App\Models\Space
     */
    protected function filterSpaces(Filter $filters)
    {
        return Space::filter($filters)->first();
    }
}
