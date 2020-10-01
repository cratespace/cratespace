<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Business;
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

        return view('public.orders.confirmation', [
            'order' => $order = $this->findOrder($confirmationNumber),
            'business' => $this->getBusinessDetails($order),
        ]);
    }

    /**
     * Find order by confirmation number.
     *
     * @param string $confirmationNumber
     *
     * @return \App\Models\Order
     */
    protected function findOrder(string $confirmationNumber): Order
    {
        return OrderQuery::findByConfirmationNumber(
            $confirmationNumber
        )->load(['space', 'charge']);
    }

    /**
     * Get details of business the order belongs to.
     *
     * @param \App\Models\Order $order
     *
     * @return \App\Models\Business
     */
    protected function getBusinessDetails(Order $order): Business
    {
        return Business::where('user_id', $order->user_id)->first();
    }
}
