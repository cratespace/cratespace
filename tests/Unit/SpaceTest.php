<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Space;
use Illuminate\Support\Str;
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
    public function it_can_get_price_in_dollars()
    {
        $space = create(Space::class, ['price' => 10.67]);

        $this->assertDataBaseHas('spaces', ['price' => 1067]);

        $this->assertTrue(is_string($space->price));
        $this->assertTrue(Str::contains($space->price, '$'));
        $this->assertEquals('$10.67', $space->price);
    }
}
