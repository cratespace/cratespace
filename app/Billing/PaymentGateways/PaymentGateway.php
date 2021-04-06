<?php

namespace App\Billing\PaymentGateways;

use App\Contracts\Billing\Product;
use App\Billing\PaymentTokens\GeneratePaymentToken;

abstract class PaymentGateway
{
    /**
     * Indicate if the charge was performed successfully.
     *
     * @var bool
     */
    protected $successful = false;

    /**
     * The callback to run during a charge process.
     *
     * @var \Closure
     */
    protected static $duringCharge;

    /**
     * Charge the customer the given amount.
     *
     * @param int        $amount
     * @param array      $details
     * @param array|null $options
     *
     * @return mixed
     */
    abstract public function charge(int $amount, array $details, ?array $options = null);

    /**
     * Generate valid test payment token.
     *
     * @param \App\Contracts\Billing\Product|null $product
     *
     * @return string
     */
    abstract public function getValidTestToken(?Product $product = null): string;

    /**
     * Determine if the charge was succesful.
     *
     * @return bool
     */
    public function successful(): bool
    {
        return $this->successful;
    }

    /**
     * Get instance of payment token generator.
     *
     * @return \App\Billing\PaymentTokens\GeneratePaymentToken
     */
    protected function createTokenGenerator(): GeneratePaymentToken
    {
        return app(GeneratePaymentToken::class);
    }
}
