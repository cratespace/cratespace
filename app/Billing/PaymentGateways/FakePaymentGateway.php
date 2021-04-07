<?php

namespace App\Billing\PaymentGateways;

use App\Billing\Natives\Payment;
use App\Exceptions\InvalidPurchaseTokenException;

class FakePaymentGateway extends PaymentGateway
{
    /**
     * Fake credit card number used for testing purposes.
     */
    public const TEST_CARD_NUMBER = '4242424242424242';

    /**
     * The total amount paid.
     *
     * @var int
     */
    protected $charges = [];

    /**
     * Create new instance of Fake payment gateway.
     *
     * @return void
     */
    public function __construct()
    {
        $this->charges = collect();
    }

    /**
     * Charge the customer the given amount.
     *
     * @param int        $amount
     * @param array      $details
     * @param array|null $options
     *
     * @return mixed
     */
    public function charge(int $amount, array $details, ?array $options = null)
    {
        if (! is_null(static::$beforeFirstChargeCallback)) {
            $callback = static::$beforeFirstChargeCallback;

            static::useBeforeFirstCharge(null);

            call_user_func($callback, $this);
        }

        if (! $this->validateTestToken($details['token'])) {
            throw new InvalidPurchaseTokenException("Token [{$details['token']}] is invalid");
        }

        $this->successful = true;

        $payment = new Payment($amount);
        $payment->wasSuccessful(true);

        $this->charges[] = $amount;

        return $payment;
    }

    /**
     * Get total charge amount.
     *
     * @return int
     */
    public function getTotalCharge(): int
    {
        return collect($this->charges)->sum();
    }
}
