<?php

namespace App\Billing\PaymentGateways;

use App\Models\Order;
use InvalidArgumentException;
use App\Billing\Charges\Charge;
use Illuminate\Support\Facades\Crypt;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class FakePaymentGateway extends PaymentGateway implements PaymentGatewayContract
{
    /**
     * Payment token prefix.
     *
     * @param string $key
     */
    protected $prefix = 'fake-tok_';

    /**
     * Get total amount the customer is charged.
     *
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * Charge the customer with the given amount.
     *
     * @param \App\Models\Order $order
     * @param string            $paymentToken
     *
     * @return void
     */
    public function charge(Order $order, string $paymentToken): void
    {
        $this->runBeforeChargesCallback();

        if (! $this->matches($paymentToken)) {
            $this->handlePaymentFailure("Token {$paymentToken} is invalid", $order->total);
        }

        $this->total = $order->total;

        $this->saveChargeDetails($order, $paymentToken);
    }

    /**
     * Generate payment token.
     *
     * @param array $card
     *
     * @return string
     */
    public function generateToken(array $card): string
    {
        if (is_null($card['number'])) {
            throw new InvalidArgumentException('Card number not found');
        }

        $token = $this->prefix . Crypt::encryptString($card['number']);

        $this->tokens[$token] = $card['number'];

        return $token;
    }
}
