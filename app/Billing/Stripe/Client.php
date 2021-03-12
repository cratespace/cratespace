<?php

namespace App\Billing\Stripe;

use Stripe\StripeClientInterface;
use App\Billing\Stripe\Concerns\ManagesCustomers;
use App\Contracts\Billing\Client as ClientContract;
use App\Billing\Stripe\Concerns\ManagesPaymentIntents;

class Client implements ClientContract
{
    use ManagesCustomers;
    use ManagesPaymentIntents;

    /**
     * Create new Stripe client instance.
     *
     * @param \Stripe\StripeClientInterface $client
     */
    public function __construct(StripeClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Get current instance of Stripe client.
     *
     * @return \Stripe\StripeClientInterface
     */
    public function client(): StripeClientInterface
    {
        return $this->client;
    }
}
