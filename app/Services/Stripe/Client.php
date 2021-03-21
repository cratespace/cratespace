<?php

namespace App\Services\Stripe;

use Throwable;
use Stripe\StripeClient;
use InvalidArgumentException;
use Stripe\Util\LoggerInterface;
use Stripe\StripeClientInterface;
use Illuminate\Contracts\Foundation\Application;

class Client
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
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Create Stripe client instance.
     *
     * @param array|null $config
     *
     * @return \Stripe\StripeClientInterface
     */
    public function make(?array $config = null): StripeClientInterface
    {
        if (is_null($config)) {
            $config = [
                'api_key' => $this->app['config']->get('billing.secret'),
                'stripe_account' => $this->app['config']->get('billing.account'),
            ];
        }

        $this->stripe = new StripeClient($this->options($config));

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
            'stripe_version' => static::STRIPE_VERSION,
        ], $options);
    }

    /**
     * Get instance of logger.
     *
     * @return \Stripe\Util\LoggerInterface
     */
    public function logger(): LoggerInterface
    {
        return $this->app->make(LoggerInterface::class);
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
     * Dynamically get Stripe client services.
     *
     * @param mixed $name
     * @param mixed $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        try {
            $stripe = $this->app->make(self::class)->stripe();

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
