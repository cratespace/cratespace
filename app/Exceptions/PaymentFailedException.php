<?php

namespace App\Exceptions;

use App\Contracts\Billing\Payment;

class PaymentFailedException extends IncompletePaymentException
{
    /**
     * Create a new PaymentFailure instance.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return \App\Exceptions\PaymentFailedException
     */
    public static function invalidPaymentMethod(Payment $payment): PaymentFailedException
    {
        return new static(
            $payment,
            'The payment attempt failed because of an invalid payment method.'
        );
    }
}
