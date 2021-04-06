<?php

namespace App\Events;

use App\Services\Stripe\Refund;
use App\Services\Stripe\Payment;

class PaymentRefunded extends PaymentEvent
{
    /**
     * The Stripe refund instance.
     *
     * @var \App\Services\Stripe\Refund
     */
    public $refund;

    /**
     * Create new Payment refunded event instance.
     *
     * @param \App\Services\Stripe\Refund $refund
     *
     * @return void
     */
    public function __construct(Refund $refund)
    {
        $this->refund = $refund;

        parent::__construct(new Payment($refund->payment_intent));
    }
}
