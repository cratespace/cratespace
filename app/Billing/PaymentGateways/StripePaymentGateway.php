<?php

namespace App\Billing\PaymentGateways;

use App\Models\Order;
use App\Models\Charge;
use Stripe\StripeClient;
use Stripe\Service\ChargeService;
use App\Exceptions\PaymentFailedException;
use Stripe\Exception\InvalidRequestException;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class StripePaymentGateway extends PaymentGateway implements PaymentGatewayContract
{
    /**
     * Stripe secret api key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Test credit card number.
     */
    public const TEST_CARD_NUMBER = '4242424242424242';

    /**
     * Total charge amount.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * Create new instance of stripe payment gateway.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

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
        try {
            $stripeCharge = $this->getStripeCharges()->create([
                'amount' => $this->total = $order->total,
                'currency' => config('defaults.billing.currency'),
                'source' => $paymentToken,
                'description' => config('defaults.billing.transaction-description'),
            ]);

            $this->createCharge($order, $paymentToken, (array) $stripeCharge);
        } catch (InvalidRequestException $e) {
            throw new PaymentFailedException($e->getMessage(), $amount);
        }
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
        $token = $this->createStripeClient()
            ->tokens
            ->create(['card' => $card])
            ->id;

        $this->tokens[$token] = $card['number'];

        return $token;
    }

    /**
     * Create stripe charge handler.
     *
     * @return \Stripe\Service\ChargeService
     */
    protected function getStripeCharges(): ChargeService
    {
        return $this->createStripeClient()->charges;
    }

    /**
     * Create new stripe client instance.
     *
     * @return \Stripe\StripeClient
     */
    protected function createStripeClient(): StripeClient
    {
        return new StripeClient($this->apiKey);
    }
}
