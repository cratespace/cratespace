<?php

namespace App\Http\Controllers\Business;

use App\Models\Order;
use App\Queries\OrderQuery;
use App\Filters\OrderFilter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, OrderFilter $filters)
    {
        return view('business.orders.index', [
            'resource' => OrderQuery::ForBusiness($filters, $request->search)
                ->paginate($request->perPage ?? 10),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $this->authorize('delete', $order);

        return view('business.orders.show', [
            'order' => $order,
            'space' => $order->space,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateOrderStatusRequest $request
     * @param \App\Models\Order                           $order
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderStatusRequest $request, Order $order)
    {
        $order->update(['status' => $request->status]);

        if ($request->wantsJson()) {
            return response($order->fresh(), 201);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        $order->delete();

        if ($request->wantsJson()) {
            return response([], 204);
        }

        return redirect()->route('orders.index');
    }
}
