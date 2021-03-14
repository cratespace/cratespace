<?php

namespace App\Billing\Stripe;

use App\Support\Attribute;
use App\Exceptions\PaymentFailedException;
use Illuminate\Contracts\Support\Arrayable;
use Stripe\PaymentIntent as StripePaymentIntent;
use App\Exceptions\PaymentActionRequiredException;
use App\Contracts\Billing\Payment as PaymentContract;

class Payment extends Attribute implements PaymentContract, Arrayable
{
    /**
     * Attribute identifier.
     *
     * @var string
     */
    protected $name = 'payment';

    /**
     * The Stripe PaymentIntent instance.
     *
     * @var \Stripe\PaymentIntent
     */
    protected $paymentIntent;

    /**
     * Create a new Payment instance.
     *
     * @param \Stripe\PaymentIntent $paymentIntent
     *
     * @return void
     */
    public function __construct(StripePaymentIntent $paymentIntent)
    {
        $this->paymentIntent = $paymentIntent;
    }

    /**
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount(): string
    {
        return $this->formatAmount(
            $this->rawAmount(),
            $this->paymentIntent->currency
        );
    }

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount(): int
    {
        return $this->paymentIntent->amount;
    }

    /**
     * The Stripe PaymentIntent client secret.
     *
     * @return string
     */
    public function clientSecret(): string
    {
        return $this->paymentIntent->client_secret;
    }

    /**
     * Determine if the payment needs a valid payment method.
     *
     * @return bool
     */
    public function requiresPaymentMethod(): bool
    {
        return $this->paymentIntent->status === StripePaymentIntent::STATUS_REQUIRES_PAYMENT_METHOD;
    }

    /**
     * Determine if the payment needs an extra action like 3D Secure.
     *
     * @return bool
     */
    public function requiresAction()
    {
        return $this->paymentIntent->status === StripePaymentIntent::STATUS_REQUIRES_ACTION;
    }

    /**
     * Determine if the payment was cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool
    {
        return $this->paymentIntent->status === StripePaymentIntent::STATUS_CANCELED;
    }

    /**
     * Determine if the payment was successful.
     *
     * @return bool
     */
    public function isSucceeded(): bool
    {
        return $this->paymentIntent->status === StripePaymentIntent::STATUS_SUCCEEDED;
    }

    /**
     * Validate if the payment intent was successful and throw an exception if not.
     *
     * @return void
     *
     * @throws \App\Exceptions\PaymentFailedException
     * @throws \App\Exceptions\PaymentFailure
     */
    public function validate(): void
    {
        if ($this->requiresPaymentMethod()) {
            throw PaymentFailedException::invalidPaymentMethod($this);
        } elseif ($this->requiresAction()) {
            throw PaymentActionRequiredException::incomplete($this);
        }
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return (array) $this->paymentIntent;
    }

    /**
     * Dynamically get values from the Stripe PaymentIntent.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->paymentIntent->{$key};
    }
}
