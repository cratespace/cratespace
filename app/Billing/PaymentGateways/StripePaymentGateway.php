<?php

namespace App\Billing\PaymentGateways;

use Stripe\StripeClient;
use Stripe\Service\ChargeService;
use App\Exceptions\PaymentFailedException;
use Stripe\Exception\InvalidRequestException;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class StripePaymentGateway implements PaymentGatewayContract
{
    /**
     * Stripe secret api key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Total charge amount.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * Create new isnatnce of stripe payment gateway.
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
     * @param int         $amount
     * @param string      $paymentToken
     * @param string|null $destinationAccountId
     *
     * @return void
     */
    public function charge(int $amount, string $paymentToken, ?string $destinationAccountId = null): void
    {
        try {
            $this->getStripeCharges()->create([
                'amount' => $this->total = $amount,
                'currency' => config('defaults.billing.currency'),
                'source' => $paymentToken,
                'description' => config('defaults.billing.transaction-description'),
                'destination' => [
                    'account' => $destinationAccountId,
                    'amount' => $amount * .9,
                ],
            ]);
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
        $tokenObject = $this->makeStripeClient()->tokens->create(
            ['card' => $card],
            ['api_key' => $this->apiKey]
        );

        return $tokenObject->id;
    }

    /**
     * Create stripe charge handler.
     *
     * @return \Stripe\Service\ChargeService
     */
    protected function getStripeCharges(): ChargeService
    {
        return $this->makeStripeClient()->charges;
    }

    /**
     * Create new stripe client instance.
     *
     * @return \Stripe\StripeClient
     */
    protected function makeStripeClient(): StripeClient
    {
        return new StripeClient($this->apiKey);
    }
}
