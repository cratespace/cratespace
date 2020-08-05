<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderConfirmationController extends Controller
{
    /**
     * Display the specified order details.
     *
     * @param string $confirmationNumber
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $confirmationNumber)
    {
        return view('public.orders.confirmation', [
            'order' => Order::findByConfirmationNumber($confirmationNumber),
        ]);
    }
}
