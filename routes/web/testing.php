<?php

use App\Models\Order;
use App\Mail\NewOrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Orders\Order as PurchaseOrder;

Route::group([
    'prefix' => 'testing',
    'middleware' => ['auth:sentinel', 'auth.admin'],
], function () {
    Route::get('/mail', function (Request $request) {
        if (Order::count() <= 0) {
            $order = create(Order::class);
        } else {
            $order = Order::first();
        }

        $order = PurchaseOrder::find($order->id);

        // return (new NewOrderPlaced($order))->render();
    });
});
