<?php

namespace App\Billing\Gateways;

abstract class Gateway
{
    /**
     * Indicate if the charge was performed successfully.
     *
     * @var bool
     */
    protected $successful = false;

    /**
     * The total amount charged.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * Make a "one off" charge on the customer for the given amount.
     *
     * @param int        $amount
     * @param string     $paymentMethod
     * @param array|null $options
     *
     * @return mixed
     */
    abstract public function charge(int $amount, string $paymentMethod, array $options = []);
}
