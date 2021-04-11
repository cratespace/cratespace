<?php

namespace Tests\Unit\Queries;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Space;
use App\Queries\SpaceQuery;
use App\Filters\SpaceFilter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceQueryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The query builder instance.
     *
     * @var \App\Queries\SpaceQuery
     */
    protected $query;

    protected function setUp(): void
    {
        parent::setUp();

        $this->query = new SpaceQuery();
    }

    public function testListingQuery()
    {
        // Available spaces.
        $availableSpaces = create(Space::class, [
            'reserved_at' => null,
        ], 20);

        // Reserved spaces.
        $reservedSpaces = create(Space::class, [
            'reserved_at' => Carbon::now(),
        ], 20);

        // Expired spaces.
        $expiredSpaces = create(Space::class, [
            'departs_at' => Carbon::yesterday(),
        ], 20);

        $query = $this->query->listing(new SpaceFilter(request()));

        $this->assertEquals(20, $query->count());
        $this->assertTrue($query->get()->contains(function ($space) use ($availableSpaces) {
            return $availableSpaces->contains($space);
        }));
        $this->assertFalse($query->get()->contains(function ($space) use ($reservedSpaces) {
            return $reservedSpaces->contains($space);
        }));
        $this->assertFalse($query->get()->contains(function ($space) use ($expiredSpaces) {
            return $expiredSpaces->contains($space);
        }));
    }
}
