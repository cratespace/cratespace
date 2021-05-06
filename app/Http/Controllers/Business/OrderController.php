<?php

namespace App\Http\Controllers\Business;

use Inertia\Inertia;
use App\Models\Order;
use App\Jobs\CancelOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\OrderRequest;
use App\Http\Responses\Business\OrderResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('manage', Order::class);

        return Inertia::render('Business/Orders/Index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Business\OrderRequest $request
     * @param \App\Models\Order                        $order
     *
     * @return mixed
     */
    public function update(OrderRequest $request, Order $order)
    {
        $request->tap(fn () => $order->confirm());

        return OrderResponse::dispatch($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     *
     * @return mixed
     */
    public function destroy(Order $order)
    {
        $this->authorize('manage', $order);

        CancelOrder::dispatch($order);

        return OrderResponse::dispatch();
    }
}
