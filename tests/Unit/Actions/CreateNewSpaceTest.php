<?php

namespace Tests\Unit\Actions;

use Mockery as m;
use Tests\TestCase;
use App\Products\Products\Space;
use App\Actions\Products\CreateNewSpace;
use App\Products\Factories\SpaceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewSpaceTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        m::close();
    }

    public function testCreateNewSpace()
    {
        $data = $this->getSpaceData();
        $factory = m::mock(SpaceFactory::class);
        $factory->shouldReceive('getProductInstance')
            ->andReturn($space = m::mock(Space::class));
        $factory->shouldReceive('make')
            ->with($data)
            ->andReturn($space);

        $creator = new CreateNewSpace($factory);

        $this->assertInstanceOf(Space::class, $creator->create($data));
    }

    /**
     * Get data necessary to create a new space.
     *
     * @return array
     */
    public function getSpaceData(): array
    {
        return [
            'departs_at' => now()->addMonths(rand(1, 3)),
            'arrives_at' => now()->addMonths(rand(2, 3)),
            'reserved_at' => null,
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
            'height' => rand(1, 9),
            'width' => rand(1, 9),
            'length' => rand(1, 9),
            'weight' => rand(1, 9),
            'note' => $this->faker->sentence(7),
            'price' => $price = rand(100, 900),
            'tax' => round($price * 0.05), // 5% tax
            'type' => $this->faker->randomElement(['Local', 'International']),
        ];
    }
}
