<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Filters\OrderFilter;
use Illuminate\Http\Request;
use App\Http\Requests\Order as OrderForm;
use App\Resources\Orders\Manager as OrderManager;
use App\Http\Requests\OrderUpdate as OrderUpdateForm;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\OrderFilter $filters
     * @return \Illuminate\Http\Response
     */
    public function index(OrderFilter $filters)
    {
        if (! request()->has('status')) {
            return redirect()->route('orders.index', ['status' => 'Pending']);
        }

        return view('businesses.orders.index', [
            'orders' => app('listings.order')->get($filters, user())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderForm $request)
    {
        (new OrderManager())->process($request->validated());

        return success(route('listings'), 'Order placed successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('businesses.orders.show', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateForm $request, Order $order)
    {
        $order->markAs($request->status);

        return response([
            'message' => $order->refresh()->status
        ], 200);
    }
}
