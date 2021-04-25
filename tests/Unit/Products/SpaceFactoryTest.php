<?php

namespace Tests\Unit\Products;

use Tests\TestCase;
use App\Models\User;
use App\Products\Products\Space;
use App\Products\Factories\SpaceFactory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpaceFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testMakeProduct()
    {
        $this->signIn($user = create(User::class));
        $factory = new SpaceFactory();

        $user->setResponsibility($factory->getProductInstance());

        $space = $factory->make($this->getSpaceData());

        $this->assertInstanceOf(Space::class, $space);
    }

    public function testResponsibilityCheck()
    {
        $this->signIn(create(User::class));

        $this->withoutExceptionHandling();
        $this->expectException(AuthorizationException::class);
        $this->expectExceptionMessage('User is not authorized to perform this action');

        $factory = new SpaceFactory();

        $space = $factory->make($this->getSpaceData());

        $this->assertInstanceOf(Space::class, $space);
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
