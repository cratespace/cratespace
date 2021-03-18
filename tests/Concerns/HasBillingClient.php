<?php

namespace Tests\Concerns;

use Stripe\StripeClient;
use App\Billing\Stripe\Client;
use Stripe\StripeClientInterface;
use App\Contracts\Billing\Client as ClientContract;

trait HasBillingClient
{
    /**
     * Get instance of billing client.
     *
     * @return \App\Contracts\Billing\Client
     */
    public function getClient(): ClientContract
    {
        return new Client($this->getStripeClient());
    }

    /**
     * Get instance of Stripe client.
     *
     * @return \Stripe\StripeClientInterface
     */
    protected function getStripeClient(): StripeClientInterface
    {
        return new StripeClient(config('billing.secret'));
    }
}
