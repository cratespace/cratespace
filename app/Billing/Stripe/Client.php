<?php

namespace App\Billing\Stripe;

use Stripe\StripeClientInterface;
use App\Billing\Stripe\Concerns\ManagesRefunds;
use App\Billing\Stripe\Concerns\ManagesCustomers;
use App\Contracts\Billing\Client as ClientContract;
use App\Billing\Stripe\Concerns\ManagesPaymentIntents;
use App\Billing\Stripe\Concerns\ManagesPaymentMethods;

class Client implements ClientContract
{
    use ManagesCustomers;
    use ManagesPaymentIntents;
    use ManagesPaymentMethods;
    use ManagesRefunds;

    /**
     * The Stripe API version.
     *
     * @var string
     */
    const STRIPE_VERSION = '2020-08-27';

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
     * Get the default Stripe API options.
     *
     * @param array $options
     *
     * @return array
     */
    public function options(array $options = []): array
    {
        return array_merge([
            'api_key' => $this->client->getApiKey(),
            'stripe_version' => static::STRIPE_VERSION,
        ], $options);
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
