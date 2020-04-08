<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use App\Models\Category;

class SpaceTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_user()
    {
        $space = create(Space::class);

        $this->assertInstanceOf(User::class, $space->user);
    }

    /** @test */
    public function it_has_a_path()
    {
        $space = create(Space::class);

        $this->assertEquals("/spaces/$space->uid", $space->path());
    }

    /** @test */
    public function it_can_be_marked()
    {
        $space = create(Space::class);

        $this->assertEquals('Available', $space->status);

        $space->markAs('Expired');
        $this->assertTrue($space->departed());
        $this->assertEquals('Expired', $space->status);

        $space->markAs('Available');
        $this->assertEquals('Available', $space->status);

        $space->markAs('Ordered');
        $this->assertEquals('Ordered', $space->status);

        $space->markAs('Purchased');
        $this->assertEquals('Purchased', $space->status);
    }
}
