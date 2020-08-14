<?php

declare(strict_types=1);

use App\Models\Order;
use App\Mail\OrderPlaced;
use Illuminate\Support\Facades\Route;

Route::get('/tests', function () {
    return view('public.orders.confirmation');
});

Route::get('/mailable', function () {
    $order = Order::find(1);

    return new OrderPlaced($order);
});
