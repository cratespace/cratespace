<?php

namespace App\Billing\Gateways;

use App\Contracts\Billing\Payment;

abstract class PaymentGateway
{
    /**
     * Indicate if the charge was performed successfully.
     *
     * @var bool
     */
    protected $successful = false;

    /**
     * Charge the customer the given amount.
     *
     * @param int        $amount
     * @param array      $details
     * @param array|null $options
     *
     * @return \App\Contracts\Billing\Payment
     */
    abstract public function charge(int $amount, array $details, ?array $options = null): Payment;

    /**
     * Determine if the charge was succesful.
     *
     * @return bool
     */
    public function successful(): bool
    {
        return $this->successful;
    }
}
