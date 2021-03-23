<?php

namespace App\Services\Stripe;

use App\Support\Money;
use App\Exceptions\PaymentActionRequired;
use App\Exceptions\PaymentFailedException;
use Stripe\PaymentIntent as StripePaymentIntent;
use App\Contracts\Billing\Payment as PaymentContract;

class Payment extends Resource implements PaymentContract
{
    /**
     * Resource index for usage with Stripe.
     *
     * @var string
     */
    protected static $index = 'paymentIntents';

    /**
     * Resource specific attributes.
     *
     * @var array
     */
    protected static $attributes = [
        'amount',
        'currency',
        'customer',
        'confirm',
        'description',
        'metadata',
        'payment_method',
        'receipt_email',
    ];

    /**
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount(): string
    {
        return Money::format(
            $this->rawAmount(),
            $this->resource->currency
        );
    }

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount(): int
    {
        return $this->resource->amount;
    }

    /**
     * The Stripe PaymentIntent client secret.
     *
     * @return string
     */
    public function clientSecret(): string
    {
        return $this->resource->client_secret;
    }

    /**
     * Determine if the payment needs a valid payment method.
     *
     * @return bool
     */
    public function requiresPaymentMethod(): bool
    {
        return $this->resource->status === StripePaymentIntent::STATUS_REQUIRES_PAYMENT_METHOD;
    }

    /**
     * Determine if the payment needs an extra action like 3D Secure.
     *
     * @return bool
     */
    public function requiresAction(): bool
    {
        return $this->resource->status === StripePaymentIntent::STATUS_REQUIRES_ACTION;
    }

    /**
     * Determine if the payment was successfully completed.
     *
     * @return bool
     */
    public function paid(): bool
    {
        return $this->isSucceeded();
    }

    /**
     * Determine if the payment was cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->resource->status === StripePaymentIntent::STATUS_CANCELED;
    }

    /**
     * Determine if the payment was successful.
     *
     * @return bool
     */
    public function isSucceeded(): bool
    {
        return $this->resource->status === StripePaymentIntent::STATUS_SUCCEEDED;
    }

    /**
     * Validate if the payment intent was successful and throw an exception if not.
     *
     * @return void
     *
     * @throws \App\Exceptions\PaymentActionRequired
     * @throws \App\Exceptions\PaymentFailure
     */
    public function validate(): void
    {
        if ($this->requiresPaymentMethod()) {
            throw PaymentFailedException::invalidPaymentMethod($this);
        } elseif ($this->requiresAction()) {
            throw PaymentActionRequired::incomplete($this);
        }
    }
}
