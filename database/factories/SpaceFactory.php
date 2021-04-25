<?php

namespace Database\Factories;

use Faker\Factory;
use App\Models\User;
use Faker\Generator as Faker;
use App\Products\Products\Space;
use Illuminate\Foundation\Testing\WithFaker;

class SpaceFactory
{
    use WithFaker;

    /**
     * Create new dummy space.
     *
     * @param array $data
     *
     * @return \App\Products\Products\Space
     */
    public static function createSpace(array $data = []): Space
    {
        $user = User::factory()->asBusiness()->create();

        return Space::create(array_merge([
            'code' => null,
            'departs_at' => now()->addMonths(rand(1, 3)),
            'arrives_at' => now()->addMonths(rand(2, 3)),
            'reserved_at' => null,
            'origin' => static::faker()->city,
            'destination' => static::faker()->city,
            'height' => rand(1, 9),
            'width' => rand(1, 9),
            'length' => rand(1, 9),
            'weight' => rand(1, 9),
            'note' => static::faker()->sentence(7),
            'price' => $price = rand(100, 900),
            'tax' => round($price * 0.05), // 5% tax
            'type' => static::faker()->randomElement(['Local', 'International']),
            'user_id' => $user->id,
            'base' => $user->address->country,
        ], $data));
    }

    /**
     * Custom faker instance.
     *
     * @return \Faker\Generator
     */
    public static function faker(): Faker
    {
        return Factory::create();
    }
}
