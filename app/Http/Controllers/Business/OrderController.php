<?php

namespace App\Http\Controllers\Business;

use Inertia\Inertia;
use App\Orders\Order;
use App\Jobs\CancelOrder;
use App\Queries\OrderQuery;
use App\Filters\OrderFilter;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use App\Http\Requests\Business\OrderRequest;
use App\Http\Responses\Business\OrderResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\OrderFilter $filters
     * @param \App\Queries\OrderQuery  $query
     *
     * @return \Inertia\Response
     */
    public function index(OrderFilter $filters, OrderQuery $query): InertiaResponse
    {
        $this->authorize('viewAny', Order::class);

        return Inertia::render('Business/Orders/Index', [
            'orders' => $query->business($filters)->paginate(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Business\OrderRequest $request
     * @param \App\Orders\Order                        $order
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
     * @param \App\Orders\Order $order
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
