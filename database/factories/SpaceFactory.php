<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Space;
use Illuminate\Support\Str;
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
        $user = User::factory()->asBusiness()->create();

        return [
            'code' => strtoupper(Str::random(12)),
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
            'user_id' => $user->id,
            'base' => $user->address->country,
        ];
    }
}
