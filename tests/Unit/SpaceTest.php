<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Space;
use Illuminate\Pagination\LengthAwarePaginator;

class SpaceTest extends TestCase
{
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
        create(Space::class, [], 100);

        $this->assertCount(100, Space::list()->get());
        $this->assertInstanceOf(LengthAwarePaginator::class, Space::list()->paginate());
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
}
