<?php

namespace App\Events;

use App\Contracts\Billing\Payment;

class PaymentFailed extends PaymentEvent
{
    /**
     * Create a new event instance.
     *
     * @param array                          $details
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return void
     */
    public function __construct(array $details, ?Payment $payment = null)
    {
        parent::__construct($payment);
    }
}
