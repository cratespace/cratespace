<?php

namespace App\Http\Controllers\Customers;

use App\Jobs\CancelOrder;
use App\Contracts\Billing\Order;
use App\Contracts\Billing\Product;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Contracts\Actions\MakesPurchases;
use App\Actions\Customer\DestroyPaymentToken;
use App\Actions\Customer\GeneratePaymentToken;
use App\Http\Responses\OrderCancelledResponse;
use App\Http\Responses\PurchaseFailedResponse;
use App\Http\Responses\PurchaseSucceededResponse;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(GeneratePaymentToken $generator, Product $product)
    {
        $generator->generate($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\OrderRequest           $request
     * @param \App\Contracts\Actions\MakesPurchases     $purchaser
     * @param \App\Actions\Customer\DestroyPaymentToken $destroyer
     * @param \App\Contracts\Billing\Product            $product
     *
     * @return \Illuminate\Http\Response
     */
    public function store(
        OrderRequest $request,
        MakesPurchases $purchaser,
        DestroyPaymentToken $destroyer,
        Product $product
    ) {
        $order = $purchaser->purchase($product, $request->validated());

        $destroyer->destroy($request->payment_token);

        if (! $order) {
            return PurchaseFailedResponse::dispatch();
        }

        return PurchaseSucceededResponse::dispatch($order);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Contracts\Billing\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contracts\Billing\Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        CancelOrder::dispatch($order);

        return OrderCancelledResponse::dipatch();
    }
}
