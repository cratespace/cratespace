<?php

namespace App\Billing\Gateways;

use App\Support\Money;
use App\Billing\Stripe\Payment;
use App\Contracts\Billing\Client;
use Illuminate\Support\Facades\Auth;

class StripeGateway extends Gateway
{
    /**
     * Create new instance of Stripe payment gateway.
     *
     * @param \App\Contracts\Billing\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Make a "one off" charge on the customer for the given amount.
     *
     * @param int        $amount
     * @param array      $details
     * @param array|null $options
     *
     * @return mixed
     */
    public function charge(int $amount, array $details, ?array $options = null)
    {
        $details = array_merge([
            'amount' => $amount,
            'customer' => $this->customer(),
            'confirmation_method' => 'automatic',
            'confirm' => true,
            'currency' => Money::preferredCurrency(),
        ], $details);

        $payment = new Payment(
            $this->client->createIntent($details, $this->client->options())
        );

        $payment->validate();

        return $payment;
    }

    /**
     * Get the Stripe ID of the customer making the request to purchase.
     *
     * @return string|null
     */
    public function customer(): ?string
    {
        return Auth::user()->customerId();
    }
}
