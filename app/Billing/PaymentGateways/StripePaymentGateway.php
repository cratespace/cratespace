<?php

namespace App\Billing\PaymentGateways;

use App\Models\Order;
use App\Models\Charge;
use Stripe\StripeClient;
use Stripe\Service\ChargeService;
use Stripe\Charge as StripeCharge;
use Stripe\Exception\InvalidRequestException;
use App\Billing\PaymentGateways\Validators\FormatValidator;
use App\Billing\PaymentGateways\Validators\TokenExistenceValidator;
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
     * Payment token prefix.
     *
     * @param string $key
     */
    protected $prefix = 'tok_';

    /**
     * Payment token validators.
     *
     * @var array
     */
    protected static $validators = [
        FormatValidator::class,
        TokenExistenceValidator::class,
    ];

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
        $this->runBeforeChargesCallback();

        if (! $this->matches($paymentToken)) {
            $this->handlePaymentFailure("Token {$paymentToken} is invalid", $order->total);
        }

        try {
            $stripeCharge = $this->getStripeCharges()->create([
                'amount' => $this->total = $order->total,
                'currency' => $this->getBillingConfigurations()['currency'],
                'source' => $paymentToken,
                'description' => $this->getBillingConfigurations()['transaction-description'],
            ]);

            $this->saveChargeDetails(
                $order,
                $paymentToken,
                $this->prepareChargeData($stripeCharge)
            );
        } catch (InvalidRequestException $e) {
            $this->handlePaymentFailure($e->getMessage(), $order->total);
        }
    }

    /**
     * Extract stripe charge response data.
     *
     * @param \Stripe\Charge $stripeCharge
     *
     * @return array
     */
    protected function prepareChargeData(StripeCharge $stripeCharge): array
    {
        return (array) json_decode($stripeCharge->getLastResponse()->body);
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
