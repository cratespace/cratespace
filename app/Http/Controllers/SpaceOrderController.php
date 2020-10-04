<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Http\Requests\PlaceOrderRequest;
use App\Contracts\Billing\PaymentGateway;
use App\Exceptions\PaymentFailedException;
use App\Contracts\Actions\CreatesNewOrders;

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
     * @param \App\Http\Requests\PlaceOrderRequest    $request
     * @param \App\Contracts\Actions\CreatesNewOrders $creator
     * @param \App\Models\Space                       $space
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PlaceOrderRequest $request, CreatesNewOrders $creator, Space $space)
    {
        $order = $creator->create($space, $request->validated());

        try {
            $this->paymentGateway->charge($order, $this->generateToken($request));
        } catch (PaymentFailedException $e) {
            $order->cancel();

            throw $e;
        }

        return $request->wantsJson()
            ? $this->successJson($order->toArray(), 201)
            : $this->success(
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
