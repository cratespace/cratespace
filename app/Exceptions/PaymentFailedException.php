<?php

namespace App\Exceptions;

use App\Billing\Attributes\Payment;

class PaymentFailedException extends IncompletePaymentException
{
    /**
     * Create a new PaymentFailedException instance.
     *
     * @param \App\Billing\Attributes\Payment $payment
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
