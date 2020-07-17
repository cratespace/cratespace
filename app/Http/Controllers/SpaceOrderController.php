<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Http\Requests\OrderRequest;
use App\Contracts\Billing\PaymentGateway;

class SpaceOrderController extends Controller
{
    /**
     * Instance of payment gateway.
     *
     * @var \App\Billing\FakePaymentGateway
     */
    protected $paymentGateway;

    /**
     * Create new controller instance.
     *
     * @param \App\Contracts\Billing\PaymentGateway $paymentGateway
     */
    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\OrderRequest $request
     * @param \App\Models\Space               $space
     *
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request, Space $space)
    {
        // For testing purposes
        $this->paymentGateway->charge(
            $space->getPriceInCents(),
            $request->payment_token
        );

        $order = $space->order()->create($request->except('payment_token'));

        if ($request->wantsJson()) {
            return response(['order' => $order], 201);
        }

        return redirect()->route('public.commons.thank-you');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Space $space
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Space $space)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\OrderRequest $request
     * @param \App\Models\Space               $space
     *
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Space $space)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Space $space
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Space $space)
    {
    }
}
