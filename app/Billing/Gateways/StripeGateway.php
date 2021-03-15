<?php

namespace App\Billing\Gateways;

use App\Support\Money;
use App\Billing\Stripe\Payment;
use App\Contracts\Billing\Client;

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
     * @param string     $paymentMethod
     * @param array|null $options
     *
     * @return mixed
     */
    public function charge(int $amount, string $paymentMethod, array $options = [])
    {
        $payment = new Payment(
            $this->client->createIntent(
                $this->defaultOptions([
                    'amount' => $amount,
                    'payment_method' => $paymentMethod,
                ] + $options),
                $this->client->options()
            )
        );

        $payment->validate();

        $this->successful = true;

        $this->total = $payment->amount();

        return $payment;
    }

    /**
     * All default options required to create a payment intent.
     *
     * @param array $overrides
     *
     * @return array
     */
    public function defaultOptions(array $overrides = []): array
    {
        return array_merge([
            'confirmation_method' => 'automatic',
            'confirm' => true,
            'currency' => Money::preferredCurrency(),
        ], $overrides);
    }

    /**
     * Get native Stripe client.
     *
     * @return \App\Contracts\Billing\Client
     */
    public function client(): Client
    {
        return $this->client;
    }
}
