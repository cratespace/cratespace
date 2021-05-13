<?php

namespace App\Billing\Gateways;

use App\Billing\Natives\Payment;
use App\Billing\Token\ValidatePaymentToken;
use App\Exceptions\InvalidPaymentTokenException;

class FakePaymentGateway extends PaymentGateway
{
    /**
     * The total amount charged.
     *
     * @var integer
     */
    protected $total = 0;

    /**
     * The payment token validator instance.
     *
     * @var \App\Billing\Token\ValidatePaymentToken
     */
    protected $tokenValidator;

    /**
     * Create new FakePaymentGateway instance.
     *
     * @param \App\Billing\Token\ValidatePaymentToken $tokenValidator
     *
     * @return void
     */
    public function __construct(ValidatePaymentToken $tokenValidator)
    {
        $this->tokenValidator = $tokenValidator;
    }

    /**
     * Charge the customer the given amount.
     *
     * @param int        $amount
     * @param array      $details
     * @param array|null $options
     *
     * @return \App\Contracts\Billing\Payment
     */
    public function charge(int $amount, array $details, ?array $options = null): Payment
    {
        if (! $this->tokenValidator->validate($token = $details['payment_token'])) {
            throw new InvalidPaymentTokenException("Token [{$token}] is invalid");
        }

        $this->total += $amount;

        return new Payment($amount, $details);
    }
}
