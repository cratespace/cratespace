<?php

namespace Tests\Concerns;

use Faker\Factory;
use Faker\Generator as Faker;

trait HasValidParameters
{
    /**
     * List of valida parameters to create a space.
     *
     * @param array $overrides
     *
     * @return array
     */
    public static function validParametersForSpace(array $overrides = []): array
    {
        return array_merge([
            'departs_at' => now()->addMonths(rand(1, 2)),
            'arrives_at' => now()->addMonths(rand(3, 4)),
            'origin' => static::fake()->city,
            'destination' => static::fake()->city,
            'height' => rand(1, 9),
            'width' => rand(1, 9),
            'length' => rand(1, 9),
            'weight' => rand(1, 9),
            'note' => static::fake()->sentence(7),
            'price' => 10.00,
            'tax' => 0.50,
            'type' => static::fake()->randomElement(['Local', 'International']),
            'base' => 'Gondor',
        ], $overrides);
    }

    /**
     * Custom faker instance.
     *
     * @return \Faker\Generator
     */
    public static function fake(): Faker
    {
        return Factory::create();
    }
}
