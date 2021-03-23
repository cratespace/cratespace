<?php

namespace App\Exceptions;

use App\Contracts\Billing\Payment;

class PaymentActionRequired extends IncompletePaymentException
{
    /**
     * Create a new PaymentActionRequired instance.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return \App\Exceptions\PaymentActionRequired
     */
    public static function incomplete(Payment $payment): PaymentActionRequired
    {
        return new static(
            $payment,
            'The payment attempt failed because additional action is required before it can be completed.'
        );
    }
}
