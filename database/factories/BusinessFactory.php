<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Business;
use Faker\Generator as Faker;

$factory->define(Business::class, function (Faker $faker) {
    $name = $faker->unique()->company;

    return [
        'name' => $name,
        'slug' => Str::slug($name),
        // 'logo' => $faker->image('public/storage/images/company.png', 400, 400),
        'description' => $faker->sentence(7),
        'street' => '22 Auburn Side',
        'city' => 'Sri Lanka',
        'state' => 'Western',
        'country' => 'Sri Lanka',
        'postcode' => 13500,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'user_id' => null,
    ];
});
