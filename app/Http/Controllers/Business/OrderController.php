<?php

namespace App\Http\Controllers\Business;

use App\Models\Order;
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
    public function index(Request $request)
    {
        return view('business.orders.index', [
            'orders' => Order::ForBusiness($request->search)
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
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
        $order->updateStatus($request->status);

        if ($request->wantsJson()) {
            return response([], 204);
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
    }
}
