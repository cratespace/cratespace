<?php

namespace App\Billing;

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
}
