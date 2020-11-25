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
        $resource = OrderQuery::ForBusiness(
            $filters,
            $request->search
        )->paginate($request->perPage ?? 10);

        return $request->wantsJson()
            ? $this->successJson($resource, 201)
            : view('business.orders.index', compact('resource'));
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

        return $request->wantsJson()
            ? $this->successJson($order->fresh(), 201)
            : $this->success($order->space->path);
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
        $this->authorize('manage', $order);

        $order->delete();

        return $request->wantsJson()
            ? $this->successJson([], 204)
            : $this->success(route('orders.index'));
    }
}
