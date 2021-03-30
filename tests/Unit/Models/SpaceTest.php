<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Space;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceTest extends TestCase
{
    use RefreshDatabase;

    public function testResource()
    {
        $space = create(Space::class, [
            'base' => $this->faker->country,
        ]);

        $this->assertEquals('spaces', $space->getTable());
    }
}
