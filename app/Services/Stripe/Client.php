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
            'api_key' => config('billing.secret'),
            'stripe_version' => static::STRIPE_VERSION,
            'stripe_account' => config('billing.account'),
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
     * @return \App\Contracts\Services\Client
     */
    protected function getInstane(): ClientContract
    {
        return $this->app->make(ClientContract::class);
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
            if (! empty($arguments)) {
                return $stripe->{$name}($arguments);
            }

            return $stripe->{$name};
        } catch (Throwable $e) {
            $this->logger()->error($e->getMessage());

            throw new InvalidArgumentException("Property [{$name}] does not exist within Stripe client");
        }
    }
}
