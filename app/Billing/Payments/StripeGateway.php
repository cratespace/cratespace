<?php

namespace App\Billing\Payments;

use Stripe\StripeClient;

class StripeGateway extends Gateway
{
    /**
     * Attempt charge procedure.
     *
     * @param int    $amount
     * @param string $token
     *
     * @return void
     */
    public function charge(int $amount, string $token): void
    {
    }

    protected function client(): StripeClient
    {
        return app('stripe.client');
    }
}
