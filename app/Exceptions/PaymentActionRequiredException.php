<?php

namespace App\Exceptions;

use Exception;
use App\Contracts\Billing\Payment;

class PaymentActionRequiredException extends Exception
{
    /**
     * Create a new PaymentActionRequired instance.
     *
     * @param \App\Billing\Attributes\Payment $payment
     *
     * @return \App\Exceptions\PaymentActionRequiredException
     */
    public static function incomplete(Payment $payment): PaymentActionRequiredException
    {
        return new static(
            $payment,
            'The payment attempt failed because additional action is required before it can be completed.'
        );
    }
}
