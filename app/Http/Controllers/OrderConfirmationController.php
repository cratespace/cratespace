<?php

namespace App\Http\Controllers;

use App\Queries\OrderQuery;

class OrderConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $confirmationNumber)
    {
        cache()->flush();

        $order = OrderQuery::findByConfirmationNumber($confirmationNumber)
            ->load(['space', 'charge']);

        return view('public.orders.confirmation', [
            'order' => $order,
        ]);
    }
}
