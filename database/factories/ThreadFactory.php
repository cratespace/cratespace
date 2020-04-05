<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Thread::class, function (Faker $faker) {
    $title = $faker->sentence(4);

    return [
        'user_id' => create(User::class),
        'channel_id' => create(Channel::class),
        'title' => $title,
        'body' => $faker->paragraph(5),
        'visits' => 0,
        'slug' => Str::slug($title),
        'locked' => false,
        'pinned' => false,
        'replies_count' => 0,
    ];
});
