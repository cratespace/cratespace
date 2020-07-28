<?php

namespace App\Billing\PaymentGateways;

use Closure;
use Illuminate\Support\Str;
use App\Exceptions\PaymentFailedException;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class FakePaymentGateway extends PaymentGateway implements PaymentGatewayContract
{
    /**
     * Test credit card number.
     */
    public const TEST_CARD_NUMBER = '4242424242424242';

    /**
     * Call back to run as a hook before the first charge.
     *
     * @var \Closure
     */
    protected $beforeFirstChargeCallback;

    /**
     * Create new instance of fake payment gateway.
     */
    public function __construct()
    {
        $this->testToken = Str::random(40);

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
        if ($this->beforeFirstChargeCallback !== null) {
            $callback = $this->beforeFirstChargeCallback;

            $this->beforeFirstChargeCallback = null;

            call_user_func_array($callback, [$this]);
        }

        if ($paymentToken !== $this->getValidTestToken()) {
            throw new PaymentFailedException('Invalid payment token received');
        }

        $this->charges[] = $amount;

        $this->totalCharges = $this->charges->sum();
    }

    /**
     * Generate fake payment token for testing.
     *
     * @return string
     */
    public function getValidTestToken(): string
    {
        return $this->testToken;
    }

    /**
     * Set a call back to run as a hook before the first charge.
     *
     * @param \Closure $callback
     *
     * @return void
     */
    public function beforeFirstCharge(Closure $callback): void
    {
        $this->beforeFirstChargeCallback = $callback;
    }
}
