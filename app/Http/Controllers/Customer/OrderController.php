<?php

namespace App\Http\Controllers\Customer;

use Inertia\Inertia;
use App\Orders\Order;
use App\Jobs\CancelOrder;
use App\Http\Controllers\Controller;
use Inertia\Response as InertiaResponse;
use App\Contracts\Products\FindsProducts;
use App\Billing\Token\GeneratePaymentToken;
use App\Contracts\Billing\MakesNewPurchases;
use App\Http\Requests\Customer\OrderRequest;
use App\Http\Responses\Customer\OrderResponse;

class OrderController extends Controller
{
    /**
     * The product finder cation class instance.
     *
     * @var \App\Contracts\Products\FindsProducts
     */
    protected $finder;

    /**
     * Create new customer OrderController instance.
     *
     * @param \App\Contracts\Products\FindsProducts $finder
     *
     * @return void
     */
    public function __construct(FindsProducts $finder)
    {
        $this->finder = $finder;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Billing\Tokens\GeneratePaymentToken $generator
     * @param string                                   $product
     *
     * @return \Inertia\Response
     */
    public function create(GeneratePaymentToken $generator, string $product): InertiaResponse
    {
        $product = $this->finder->find($product);

        return Inertia::render('Customer/Orders/Create', [
            'stripeKey' => config('billing.services.stripe.key'),
            'product' => $product->load('owner'),
            'payementToken' => $generator->generate($product),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Customer\OrderRequest $request
     * @param \App\Contracts\Billing\MakesNewPurchases $purchaser
     *
     * @return mixed
     */
    public function store(OrderRequest $request, MakesNewPurchases $purchaser)
    {
        $order = $purchaser->purchase(
            $this->finder->find($request->product),
            $request->validated()
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

        return Inertia::render('Customer/Orders/Show', [
            'order' => $order->load('orderable', 'business'),
        ]);
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
