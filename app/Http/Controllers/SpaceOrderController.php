<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Http\Requests\PlaceOrderRequest;
use App\Contracts\Billing\PaymentGateway;
use App\Exceptions\PaymentFailedException;

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
     * @param \App\Http\Requests\PlaceOrderRequest $request
     * @param \App\Models\Space                    $space
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PlaceOrderRequest $request, Space $space)
    {
        $order = $space->placeOrder($request->except('payment_token'));

        try {
            $this->paymentGateway->charge(
                $order->totalInCents(),
                $request->payment_token
            );
        } catch (PaymentFailedException $exception) {
            $order->cancel();

            throw $exception;
        }

        if ($request->wantsJson()) {
            return response($order, 201);
        }

        return redirect()->route('public.commons.thank-you');
    }
}
