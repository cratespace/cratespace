<?php

namespace App\Billing\PaymentGateways;

use Closure;
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
     * Call back to run as a hook before the first charge.
     *
     * @var \Closure
     */
    protected $beforeFirstChargeCallback;

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
     * @return \Illuminate\Support\Collection
     */
    public function charges(): Collection
    {
        return $this->charges;
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

    /**
     * Determine and run a callback that has been set before original charge should be performed.
     *
     * @return void
     */
    protected function runBeforeChargesCallback(): void
    {
        if ($this->beforeFirstChargeCallback !== null) {
            $callback = $this->beforeFirstChargeCallback;

            $this->beforeFirstChargeCallback = null;

            call_user_func_array($callback, [$this]);
        }
    }
}
