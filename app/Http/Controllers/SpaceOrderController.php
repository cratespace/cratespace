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
    public function __invoke(PlaceOrderRequest $request, Space $space)
    {
        $order = $space->placeOrder($request->validated());

        try {
            $this->paymentGateway->charge(
                $order->getTotalInCents(),
                $this->generateToken($request)
            );
        } catch (PaymentFailedException $exception) {
            $order->delete();

            throw $exception;
        }

        if ($request->wantsJson()) {
            return response($order, 201);
        }

        return $this->success(
            route('orders.confirmation', [
                'confirmationNumber' => $order->confirmation_number,
            ]),
            'Order successfully processed.'
        );
    }

    /**
     * Generate payment token for charge.
     *
     * @param \App\Http\Requests\PlaceOrderRequest $request
     *
     * @return string
     */
    protected function generateToken(PlaceOrderRequest $request): string
    {
        return $request->payment_token ?? $this->paymentGateway->generateToken(
            $request->getCardDetails()
        );
    }
}
