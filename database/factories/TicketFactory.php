<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ticket;
use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    $customer = create(Customer::class);

    return [
        'code' => strtoupper(Str::random(12)),
        'subject' => $faker->sentence,
        'status' => 'Open',
        'priority' => $faker->randomElement(['Low', 'Medium', 'High']),
        'description' => $faker->paragraph(7),
        'attachment' => null,
        'customer_id' => $customer->id,
        'agent_id' => null,
    ];
});
