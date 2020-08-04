<?php

namespace App\Billing\PaymentGateways;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Exceptions\PaymentFailedException;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class FakePaymentGateway extends PaymentGateway implements PaymentGatewayContract
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
     * All charge amount received.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $chargeAmount = [];

    /**
     * Create new instance of fake payment gateway.
     */
    public function __construct()
    {
        $this->tokens = collect();

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

        if (!$this->tokens->has($paymentToken)) {
            throw new PaymentFailedException('Invalid payment token received', $amount);
        }

        $this->charges[] = $this->getLocalCharger([
            'amount' => $this->setChargeAmount($amount),
            'card_last_four' => substr($this->tokens[$paymentToken], -4),
            'destination' => $destinationAccountId,
        ]);
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
        $token = 'fake-tok_' . Str::random(24);

        $this->tokens[$token] = $card['card_number'] ?? self::TEST_CARD_NUMBER;

        return $token;
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
        $chargesFrom = $this->charges->count();

        call_user_func_array($callback, [$this]);

        return $this->charges->slice($chargesFrom)->reverse()->values();
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
        return $this->charges->where('id', $chargeId);
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
}
