<?php

namespace App\Billing\PaymentGateways;

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
     * Determine if the charge was succesful.
     *
     * @return bool
     */
    public function successful(): bool
    {
        return $this->successful;
    }
}
