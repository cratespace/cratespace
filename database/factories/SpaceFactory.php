<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Space;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Space::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = $this->createBusiness();

        return [
            'code' => null,
            'user_id' => $user->id,
            'height' => rand(1, 9),
            'width' => rand(1, 9),
            'length' => rand(1, 9),
            'weight' => rand(1, 9),
            'note' => null,
            'price' => 1000,
            'tax' => 50,
            'type' => $this->faker->randomElement(['Local', 'International']),
            'base' => $user->base(),
            'reserved_at' => null,
            'departs_at' => now()->addMonths(rand(1, 2)),
            'arrives_at' => now()->addMonths(rand(3, 4)),
            'origin' => $this->faker->city . ', ' . $this->faker->country,
            'destination' => $this->faker->city . ', ' . $this->faker->country,
        ];
    }

    /**
     * Create a business for the space.
     *
     * @return \App\Models\User
     */
    public function createBusiness(): User
    {
        return User::factory()->asBusiness()->create();
    }
}
