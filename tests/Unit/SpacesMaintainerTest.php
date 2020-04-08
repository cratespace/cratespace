<?php

namespace Tests\Unit;

use stdClass;
use Tests\TestCase;
use ReflectionClass;
use App\Models\Space;
use Illuminate\Support\Collection;
use App\Maintainers\SpacesMaintainer;

class SpacesMaintainerTest extends TestCase
{
    /** @test */
    public function it_can_collect_all_resources_and_make_it_a_colletction_object()
    {
        create(Space::class, ['user_id' => $this->signIn()->id], 1);

        $spaces = new SpacesMaintainer('spaces');

        $this->assertInstanceOf(Collection::class, $spaces->getResource());
        $this->assertInstanceOf(stdClass::class, $spaces->getResource()->first());
    }

    /** @test */
    public function it_can_update_the_status_of_all_avilable_spaces()
    {
        create(Space::class, [
            'user_id' => $this->signIn()->id,
            'departs_at' => now()->subMonth()
        ], 1);

        $spaces = new SpacesMaintainer('spaces');
        $space = Space::find($spaces->getResource()->first()->id);
        $space->markAs('Available');

        $this->assertEquals('Available', $space->status);

        $reflection = new ReflectionClass($spaces);
        $method = $reflection->getMethod('updateSpaceStatus');
        $method->setAccessible(true);
        $method->invokeArgs($spaces, []);
        $this->assertTrue($space->refresh()->status == 'Expired');
    }
}
