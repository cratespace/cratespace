<?php

namespace Tests\Unit\Presenters;

use Tests\TestCase;
use App\Models\Space;
use App\Support\Money;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpacePresenterTest extends TestCase
{
    use RefreshDatabase;

    public function testFormatPrice()
    {
        $space = create(Space::class);

        $this->assertEquals(
            Money::format($space->fullAmount()),
            $space->present()->price
        );
    }
}
