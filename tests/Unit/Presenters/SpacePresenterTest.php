<?php

namespace Tests\Unit\Presenters;

use Tests\TestCase;
use App\Models\Space;

class SpacePresenterTest extends TestCase
{
    /** @test */
    public function it_can_display_price_information_in_money_format()
    {
        $space = create(Space::class);
        $price = '$' . $space->price / 100;

        $this->assertEquals($price, $space->present()->price);
        $this->assertTrue(is_string($space->present()->price));
    }

    /** @test */
    public function it_can_display_volume_information()
    {
        $space = create(Space::class);
        $volume = $space->height * $space->width * $space->length;

        $this->assertEquals($volume, $space->present()->volume);
        $this->assertTrue(is_int($space->present()->volume));
    }
}
