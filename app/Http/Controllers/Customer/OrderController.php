<?php

namespace App\Http\Controllers\Customer;

use Inertia\Inertia;
use App\Orders\Order;
use App\Jobs\CancelOrder;
use App\Contracts\Products\Product;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use App\Contracts\Billing\MakesPurchases;
use App\Contracts\Products\FindsProducts;
use App\Http\Requests\Customer\OrderRequest;
use App\Http\Responses\Customer\OrderResponse;
use App\Billing\PaymentToken\GeneratePaymentToken;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Billing\PaymentTokens\GeneratePaymentToken $generator
     * @param \App\Contracts\Billing\Product                  $product
     *
     * @return \Inertia\Response
     */
    public function create(GeneratePaymentToken $generator, Product $product): InertiaResponse
    {
        return Inertia::render('Customer/Checkout/Show', [
            'payementToken' => $generator->generate($product),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Customer\OrderRequest $request
     * @param \App\Contracts\Products\FindsProducts    $finder
     * @param \App\Contracts\Billing\MakesPurchases    $purchaser
     *
     * @return mixed
     */
    public function store(OrderRequest $request, FindsProducts $finder, MakesPurchases $purchaser)
    {
        $order = $purchaser->purchase(
            $finder->find($request->product), $request->validated()
        );

        return OrderResponse::dispatch($order);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Orders\Order $order
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
     * @param \App\Orders\Order $order
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
