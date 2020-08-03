<?php

namespace App\Billing\PaymentGateways;

use Illuminate\Support\Collection;

abstract class PaymentGateway
{
    /**
     * Total amount the customer is charged.
     *
     * @var int
     */
    protected $totalCharges = 0;

    /**
     * The amount the customer ought to be charged.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $charges;

    /**
     * Create new payment gateway instance.
     */
    public function __construct()
    {
        $this->charges = collect();
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

    /**
     * Get total amount the customer is charged.
     *
     * @return \Illuminate\Support\Collection
     */
    public function charges(): Collection
    {
        return $this->charges;
    }
}
