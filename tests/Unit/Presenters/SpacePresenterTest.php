<?php

namespace Tests\Unit\Presenters;

use Tests\TestCase;
use App\Models\Space;
use App\Presenters\SpacePresenter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpacePresenterTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanGetDisplayableTotalPrice()
    {
        $space = create(Space::class, ['price' => 900, 'tax' => 100]);
        $presenter = new SpacePresenter($space);

        $this->assertEquals('$10.00', $presenter->price);
    }
}
