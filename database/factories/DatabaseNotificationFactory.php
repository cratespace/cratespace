<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Notifications\DatabaseNotification;

$factory->define(DatabaseNotification::class, function ($faker) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return user('id') ?: factory(User::class)->create()->id;
        },
        'notifiable_type' => 'App\Models\User',
        'data' => ['foo' => 'bar'],
    ];
});
