<?php

namespace App\Http\Controllers\Customer;

use Inertia\Inertia;
use App\Models\Order;
use App\Jobs\CancelOrder;
use App\Contracts\Products\Product;
use App\Http\Controllers\Controller;
use App\Contracts\Billing\MakesPurchases;
use App\Http\Requests\Customer\OrderRequest;
use App\Http\Responses\Customer\OrderResponse;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Customer/Checkout/Show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Customer\OrderRequest $request
     * @param \App\Contracts\Products\Product          $product
     * @param \App\Contracts\Billing\MakesPurchases    $purchaser
     *
     * @return mixed
     */
    public function store(OrderRequest $request, Product $product, MakesPurchases $purchaser)
    {
        $order = $purchaser->purchase($product, $request->validated());

        return OrderResponse::dispatch($order);
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
        $this->authorize('view', $order);

        return Inertia::render('Customer/Orders/Show', compact('order'));
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
        $this->authorize('destroy', $order);

        CancelOrder::dispatch($order);

        return OrderResponse::dispath();
    }
}
