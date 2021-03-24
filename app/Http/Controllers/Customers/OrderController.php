<?php

namespace App\Http\Controllers\Customers;

use App\Contracts\Billing\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Contracts\Actions\MakesPurchases;
use App\Http\Responses\PurchaseFailedResponse;
use App\Http\Responses\PurchaseSucceededResponse;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PurchaseRequest    $request
     * @param \App\Contracts\Billing\Product        $product
     * @param \App\Contracts\Actions\MakesPurchases $purchaser
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseRequest $request, Product $product, MakesPurchases $purchaser)
    {
        $order = $purchaser->purchase($product, $request->validated());

        if ($order === false) {
            return PurchaseFailedResponse::dispatch();
        }

        return PurchaseSucceededResponse::dispatch($order);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->cancel();
    }
}
