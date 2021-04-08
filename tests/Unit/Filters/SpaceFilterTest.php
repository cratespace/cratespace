<?php

namespace Tests\Unit\Filters;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Filters\SpaceFilter;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceFilterTest extends TestCase
{
    use RefreshDatabase;

    public function testFilterByDepartureDate()
    {
        create(Space::class, ['departs_at' => Carbon::now()], 10);
        $request = Request::create('/', 'GET', [
            'departs_at' => Carbon::now()->toDateString(),
        ]);

        $filter = new SpaceFilter($request);
        $query = $filter->apply(Space::query());

        $this->assertEquals(10, $query->count());
    }

    public function testFilterByArrivalDate()
    {
        create(Space::class, ['arrives_at' => Carbon::now()], 10);
        $request = Request::create('/', 'GET', [
            'arrives_at' => Carbon::now()->toDateString(),
        ]);

        $filter = new SpaceFilter($request);
        $query = $filter->apply(Space::query());

        $this->assertEquals(10, $query->count());
    }

    public function testFilterByPlaceOfOrigin()
    {
        create(Space::class, ['origin' => 'Colombo'], 10);
        create(Space::class, ['origin' => 'Jaffna'], 10);
        $request = Request::create('/', 'GET', ['origin' => 'Colombo']);

        $filter = new SpaceFilter($request);
        $query = $filter->apply(Space::query());

        $this->assertEquals(10, $query->count());
    }

    public function testFilterByPlaceOfArrival()
    {
        create(Space::class, ['destination' => 'Colombo'], 10);
        create(Space::class, ['destination' => 'Jaffna'], 10);
        $request = Request::create('/', 'GET', ['destination' => 'Colombo']);

        $filter = new SpaceFilter($request);
        $query = $filter->apply(Space::query());

        $this->assertEquals(10, $query->count());
    }
}
