<?php

namespace App\Billing\Clients;

use Stripe\StripeClientInterface;

class Stripe
{
    public function __construct(StripeClientInterface $client)
    {
        $this->client = $client;
    }
}
