<?php

namespace App\Billing\Clients;

use Stripe\StripeClientInterface;
use App\Billing\Clients\Concerns\ManagesCustomers;

class Stripe
{
    use ManagesCustomers;

    /**
     * Create new native stripe client.
     *
     * @param \Stripe\StripeClientInterface $client
     */
    public function __construct(StripeClientInterface $client)
    {
        $this->client = $client;
    }
}
