<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use App\Billing\Attributes\Payment;

class IncompletePaymentException extends Exception
{
    /**
     * The Cashier Payment object.
     *
     * @var \App\Billing\Attributes\Payment
     */
    public $payment;

    /**
     * Create a new IncompletePayment instance.
     *
     * @param \App\Billing\Attributes\Payment $payment
     * @param string                          $message
     * @param int                             $code
     * @param \Throwable|null                 $previous
     *
     * @return void
     */
    public function __construct(Payment $payment, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->payment = $payment;
    }
}
