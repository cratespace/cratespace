<?php

declare(strict_types=1);

use App\Models\Order;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Route;

Route::get('/tests', function () {
    return view('tests.generic');
});

Route::get('/mailable', function () {
    $order = Order::find(1);

    return new OrderPlacedMail($order);
});
