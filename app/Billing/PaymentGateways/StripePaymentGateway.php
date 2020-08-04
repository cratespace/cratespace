<?php

namespace App\Billing\PaymentGateways;

use Closure;
use Stripe\StripeClient;
use Illuminate\Support\Arr;
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
     * @param int         $amount
     * @param string      $paymentToken
     * @param string|null $destinationAccountId
     *
     * @return void
     */
    public function charge(int $amount, string $paymentToken, ?string $destinationAccountId = null): void
    {
        $this->runBeforeChargesCallback();

        try {
            $this->charges[] = $this->getStripeCharger()->create([
                'amount' => $this->setChargeAmount($amount),
                'currency' => config('defaults.finance.currency'),
                'source' => $paymentToken,
                'description' => config('defaults.finance.transaction-description'),
                // 'destination' => [
                //     'account' => $destinationAccountId,
                //     'amount' => $amount * .9,
                // ],
            ]);
        } catch (InvalidRequestException $e) {
            throw new PaymentFailedException($e->getMessage(), $amount);
        }
    }

    /**
     * Get latest charge details from stripe.
     *
     * @param int|null    $limit
     * @param string|null $endingBefore
     *
     * @return array
     */
    public function getCharges(?int $limit = null, ?string $endingBefore = null): array
    {
        $constraints = is_null($endingBefore)
            ? ['limit' => $limit]
            : ['ending_before' => $endingBefore];

        return $this->getStripeCharger()->all($constraints)['data'];
    }

    /**
     * Get all new charges during given callback.
     *
     * @param \Closure $callback
     *
     * @return \Illuminate\Support\Collection
     */
    public function newChargesDuring(Closure $callback): Collection
    {
        $latestCharge = Arr::first($this->getCharges(1));

        call_user_func_array($callback, [$this]);

        return $this->newChargesSince($latestCharge->id)->map(function ($stripeCharge) {
            return $this->getLocalCharger([
                'amount' => $stripeCharge['amount'],
                'card_last_four' => $stripeCharge['source']['last4'],
            ]);
        });
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
        return collect($this->getCharges(null, $chargeId));
    }

    /**
     * Get total amount the customer is charged.
     *
     * @return int
     */
    public function totalCharges(): int
    {
        return $this->totalCharges = $this->chargeAmount->sum();
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
