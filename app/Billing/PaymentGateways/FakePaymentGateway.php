<?php

namespace App\Billing\PaymentGateways;

use App\Exceptions\InvalidPurchaseTokenException;

class FakePaymentGateway extends PaymentGateway
{
    /**
     * The total amount paid.
     *
     * @var int
     */
    protected $total = 0;

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
        if (! $this->validPaymentToken($details['token'])) {
            throw new InvalidPurchaseTokenException();
        }

        $this->total += $amount;

        $this->successful = true;
    }

    protected function validPaymentToken(string $token)
    {
        return true;
    }
}
