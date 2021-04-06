<?php

namespace App\Http\Controllers\Business;

use Inertia\Inertia;
use App\Jobs\CancelOrder;
use App\Filters\OrderFilter;
use Illuminate\Http\Request;
use App\Contracts\Billing\Order;
use App\Models\Order as OrderModel;
use App\Http\Controllers\Controller;
use App\Http\Responses\OrderResponse;
use Illuminate\Contracts\Support\Responsable;
use App\Http\Responses\OrderCancelledResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(OrderFilter $filter)
    {
        $this->authorize('manage', new OrderModel());

        return Inertia::render('Business/Orders/Index', [
            'orders' => Order::listing($filter),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Contracts\Billing\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if (! (bool) $request->confirm) {
            return $this->destroy($order);
        }

        $order->confirm();

        return OrderResponse::dispatch();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contracts\Billing\Order $order
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function destroy(Order $order): Responsable
    {
        CancelOrder::dispatch($order);

        return OrderCancelledResponse::dipatch();
    }
}
