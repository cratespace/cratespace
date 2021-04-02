<?php

namespace App\Http\Controllers\Customers;

use Throwable;
use Inertia\Inertia;
use Inertia\Response;
use App\Jobs\CancelOrder;
use App\Contracts\Billing\Order;
use App\Contracts\Billing\Product;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;
use App\Actions\Product\CreateNewOrder;
use Illuminate\Contracts\Support\Responsable;
use App\Http\Responses\OrderCancelledResponse;
use App\Http\Responses\PurchaseFailedResponse;
use App\Http\Responses\PurchaseSucceededResponse;
use App\Billing\PaymentTokens\GeneratePaymentToken;

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
    public function create(GeneratePaymentToken $generator, Product $product): Response
    {
        return Inertia::render('Orders/Create', [
            'payementToken' => $generator->generate($product),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\OrderRequest           $request
     * @param \App\Contracts\Actions\MakesPurchases     $purchaser
     * @param \App\Actions\Customer\DestroyPaymentToken $destroyer
     * @param \App\Contracts\Billing\Product            $product
     *
     * @return \Illuminate\Contracts\Support\Responsable|\Illuminate\Http\RedirectResponse
     */
    public function store(OrderRequest $request, Product $product)
    {
        try {
            $order = $this->app(CreateNewOrder::class)->create(
                $product, $request->validated()
            );
        } catch (Throwable $e) {
            return PurchaseFailedResponse::dispatch($e->getMessage());
        }

        return PurchaseSucceededResponse::dispatch($order);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Contracts\Billing\Order $order
     *
     * @return \Inertia\Response
     */
    public function show(Order $order): Response
    {
        return Inertia::render('Orders/Show', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Contracts\Billing\Order $order
     *
     * @return \Illuminate\Contracts\Support\Responsable
     */
    public function destroy(Order $order): Responsable
    {
        CancelOrder::dispatch($order);

        return OrderCancelledResponse::dipatch();
    }
}
