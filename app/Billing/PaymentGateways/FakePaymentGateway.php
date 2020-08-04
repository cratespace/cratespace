<?php

namespace App\Billing\PaymentGateways;

use Illuminate\Support\Str;
use App\Exceptions\PaymentFailedException;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class FakePaymentGateway extends PaymentGateway implements PaymentGatewayContract
{
    /**
     * Test credit card number.
     */
    public const TEST_CARD_NUMBER = 4242424242424242;

    /**
     * List of fake payment tokens.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $tokens;

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
     * @param int    $amount
     * @param string $paymentToken
     *
     * @return void
     */
    public function charge(int $amount, string $paymentToken): void
    {
        $this->runBeforeChargesCallback();

        if (!$this->tokens->has($paymentToken)) {
            throw new PaymentFailedException('Invalid payment token received', $amount);
        }

        $this->charges[] = $amount;

        $this->totalCharges = $this->charges->sum();
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
     * Get total amount the customer is charged.
     *
     * @return int
     */
    public function totalCharges(): int
    {
        return $this->totalCharges;
    }
}
