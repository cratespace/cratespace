<?php

namespace App\Services\Stripe;

use Throwable;
use Stripe\Stripe;
use Stripe\StripeClient;
use InvalidArgumentException;
use Stripe\Util\LoggerInterface;
use Stripe\StripeClientInterface;
use Illuminate\Contracts\Foundation\Application;
use App\Contracts\Services\Client as ClientContract;

class Client implements ClientContract
{
    /**
     * The Stripe API version.
     *
     * @var string
     */
    const STRIPE_VERSION = '2020-08-27';

    /**
     * Instance of Cratespace application.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Instance of Stripe service.
     *
     * @var \Stripe\StripeClient
     */
    protected $stripe;

    /**
     * Create new instance of Cratespace application.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Stripe\StripeClientInterface|null           $stripe
     *
     * @return void
     */
    public function __construct(Application $app, ?StripeClientInterface $stripe = null)
    {
        $this->app = $app;
        $this->stripe = $stripe;
    }

    /**
     * Create Stripe client instance.
     *
     * @param array[] $config
     *
     * @return mixed
     */
    public function make(array $config = [])
    {
        if (is_null($this->stripe)) {
            $this->stripe = new StripeClient($this->options($config));
        }

        return $this->stripe;
    }

    /**
     * Get the default Stripe API options.
     *
     * @param array[] $options
     *
     * @return array
     */
    public function options(array $options = []): array
    {
        return array_merge([
            'api_key' => $this->getConfig('secret'),
            'stripe_version' => static::STRIPE_VERSION,
            'stripe_account' => $this->getConfig('account'),
        ], $options);
    }

    /**
     * Get instance of logger.
     *
     * @return \Stripe\Util\LoggerInterface
     */
    public function logger(): LoggerInterface
    {
        return Stripe::getLogger();
    }

    /**
     * Get instance of Stripe client.
     *
     * @return \Stripe\StripeClientInterface
     */
    public function stripe(): StripeClientInterface
    {
        return $this->stripe;
    }

    /**
     * Get a specific stripe config value.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getConfig(string $key)
    {
        return config("billing.services.stripe.{$key}");
    }

    /**
     * Get instance of Cratespace application.
     *
     * @return \Illuminate\Contracts\Foundation\Application
     */
    public function app(): Application
    {
        return $this->app;
    }

    /**
     * Get shared instance of Stripe client,.
     *
     * @return \App\Services\Stripe\Client
     */
    protected function getInstane(): Client
    {
        return $this->app->make('stripe.client');
    }

    /**
     * Dynamically get Stripe client services.
     *
     * @param mixed $name
     * @param mixed $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        $stripe = $this->getInstane()->stripe();

        try {
            $returnable = $stripe->{$name};

            if (! empty($arguments)) {
                return $returnable($arguments);
            }

            return $returnable;
        } catch (Throwable $e) {
            $this->logger()->error($e->getMessage());

            throw new InvalidArgumentException("Property [{$name}] does not exist within Stripe client");
        }
    }
}
