<?php

namespace Tests\Unit\Presenters;

use Tests\TestCase;
use App\Models\Space;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpacePresenterTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanPresentTotalPrice()
    {
        $space = create(Space::class, ['price' => 900, 'tax' => 100]);

        $this->assertEquals('$10.00', $space->present()->price);
    }
}
