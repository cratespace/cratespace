<?php

namespace App\Billing\PaymentGateways;

use Stripe\StripeClient;
use Stripe\Service\ChargeService;
use Illuminate\Support\Collection;
use App\Exceptions\PaymentFailedException;
use Stripe\Exception\InvalidRequestException;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class StripePaymentGateway extends PaymentGateway implements PaymentGatewayContract
{
    /**
     * Test credit card number.
     */
    public const TEST_CARD_NUMBER = '4242424242424242';

    /**
     * List of fake payment tokens.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $tokens;

    /**
     * Stripe services secret key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Create new Stripe payment gateway instance.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;

        parent::__construct();
    }

    /**
     * Charge the customer with the given amount.
     *
     * @param int    $amount
     * @param string $paymentToken
     *
     * @return void
     */
    public function charge(int $amount, string $paymentToken): void
    {
        try {
            $this->charges[] = $this->getStripeCharger()->create([
                'amount' => $amount,
                'currency' => config('defaults.finance.currency'),
                'source' => $paymentToken,
                'description' => config('defaults.finance.transaction-description'),
            ]);
        } catch (InvalidRequestException $e) {
            throw new PaymentFailedException($e->getMessage(), $amount);
        }
    }

    /**
     * Get latest charge details from stripe.
     *
     * @param int         $limit
     * @param string|null $endingBefore
     *
     * @return array
     */
    public function getAllCharges(int $limit = 1, ?string $endingBefore = null): array
    {
        return array_first($this->getStripeCharger()->all([
            'limit' => $limit,
        ])['data']);
    }

    /**
     * Get all new charges since given charge ID.
     *
     * @param string|null $chargeId
     *
     * @return \Illuminate\Support\Collection
     */
    public function newChargesSince(?string $chargeId = null): Collection
    {
        $newCharges = $this->getStripeCharger()->all([
            'ending_before' => $chargeId,
        ])['data'];

        return collect($newCharges);
    }

    /**
     * Create stripe charge handler.
     *
     * @return \Stripe\Service\ChargeService
     */
    protected function getStripeCharger(): ChargeService
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
}
