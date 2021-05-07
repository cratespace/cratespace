<?php

namespace App\Billing\PaymentGateways;

class FakePaymentGateway extends PaymentGateway
{
    /**
     * Charge the customer the given amount.
     *
     * @param int        $amount
     * @param array      $details
     * @param array|null $options
     *
     * @return mixed
     */
    public function charge(int $amount, array $details, ?array $options = null)
    {
    }
}
