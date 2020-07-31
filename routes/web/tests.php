<?php

declare(strict_types=1);

use App\Models\Order;
use App\Models\Space;
use Illuminate\Support\Facades\Route;

Route::get('/tests', function () {
    create(Space::class, ['user_id' => 1], 20)->each(function ($space) {
        $service = $space->getPriceInCents() * config('charges.service');

        create(Order::class, [
            'user_id' => 1,
            'space_id' => $space->id,
            'price' => $space->getPriceInCents(),
            'tax' => $space->getTaxInCents(),
            'service' => $service,
            'total' => $space->getPriceInCents() + $space->getTaxInCents() + $service,
        ]);
    });

    return 'Success!';
});
