<?php

namespace App\Services\Stripe;

use Throwable;
use Stripe\StripeClient;
use InvalidArgumentException;
use Stripe\StripeClientInterface;

class Client
{
    /**
     * The Stripe API version.
     *
     * @var string
     */
    const STRIPE_VERSION = '2020-08-27';

    /**
     * Instanceof Stripe service.
     *
     * @var \Stripe\StripeClient
     */
    protected static $stripe;

    /**
     * Create Stripe client instance.
     *
     * @return \Stripe\StripeClientInterface
     */
    public static function make(): StripeClientInterface
    {
        static::$stripe = new StripeClient(static::options());

        return static::$stripe;
    }

    /**
     * Get the default Stripe API options.
     *
     * @param array $options
     *
     * @return array
     */
    public static function options(array $options = []): array
    {
        return array_merge([
            'api_key' => config('billing.secret'),
            'stripe_version' => static::STRIPE_VERSION,
            'stripe_account' => config('billing.account'),
        ], $options);
    }

    /**
     * Dynamically get Stripe client services.
     *
     * @param mixed $name
     * @param mixed $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (is_null(static::$stripe)) {
            static::make();
        }

        try {
            return static::$stripe->{$name};
        } catch (Throwable $e) {
            throw new InvalidArgumentException("Property [{$name}] does not exist within Stripe client");
        }
    }
}
