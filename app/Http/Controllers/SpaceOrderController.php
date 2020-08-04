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
        $order = $space->placeOrder($request->validated());

        $token = $request->payment_token ?? $this->paymentGateway->generateToken(
            $request->getCardDetails()
        );

        try {
            $this->paymentGateway->charge($order->total, $token);
        } catch (PaymentFailedException $exception) {
            $order->delete();

            throw $exception;
        }

        if ($request->wantsJson()) {
            return response($order, 201);
        }

        return $this->success(
            route('thank-you'),
            'Order successfully processed.'
        );
    }
}
