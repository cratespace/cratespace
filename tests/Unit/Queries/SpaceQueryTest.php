<?php

namespace Tests\Unit\Queries;

use Mockery as m;
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Filters\SpaceFilter;
use Illuminate\Http\Request;
use App\Models\Queries\SpaceQuery;
use Illuminate\Pagination\LengthAwarePaginator;

class SpaceQueryTest extends TestCase
{
    public function tearDown(): void
    {
        m::close();
    }

    /** @test */
    public function it_has_a_listing_feature()
    {
        $spaces = create(Space::class, [], 100);
        $expiredSpaces = create(Space::class, [
            'departs_at' => Carbon::now()->subMonth(),
        ], 2);

        $this->assertCount(100, SpaceQuery::list($this->getFilter())->get());
        $this->assertEquals('Available', SpaceQuery::list($this->getFilter())->first()->status);
        $this->assertInstanceOf(LengthAwarePaginator::class, SpaceQuery::list($this->getFilter())->paginate());

        $spaces = $spaces->merge($expiredSpaces);

        foreach ($spaces as $space) {
            if ($space->isAvailable()) {
                $this->assertTrue(SpaceQuery::list($this->getFilter())->get()->contains($space));
            } else {
                $this->assertFalse(SpaceQuery::list($this->getFilter())->get()->contains($space));
            }
        }
    }

    /** @test */
    public function listing_feature_can_get_business_name_but_only_the_name()
    {
        $space = create(Space::class);

        $this->assertEquals($space->user->business->name, SpaceQuery::list($this->getFilter())->first()->business);
    }

    /**
     * Mock space filter class.
     *
     * @return \App\Filters\SpaceFiter
     */
    protected function getFilter()
    {
        return new SpaceFilter(new Request());
    }
}
