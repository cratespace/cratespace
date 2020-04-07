<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Channel;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {
    $name = $faker->unique()->word;
    return [
        'name' => $name,
        'slug' => $name,
        'description' => $faker->sentence(4),
        'archived' => false,
        'color' => $faker->hexcolor
    ];
});
