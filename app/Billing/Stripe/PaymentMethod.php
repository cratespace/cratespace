<?php

namespace App\Billing\Stripe;

use App\Support\Attribute;
use Illuminate\Database\Eloquent\Model;
use App\Billing\Stripe\Concerns\DeterminsOwner;
use Stripe\PaymentMethod as StripePaymentMethod;
use App\Exceptions\InvalidPaymentMethodException;
use App\Contracts\Billing\PaymentMethod as PaymentMethodContract;

class PaymentMethod extends Attribute implements PaymentMethodContract
{
    use DeterminsOwner;

    /**
     * Attribute identifier.
     *
     * @var string
     */
    protected $name = 'payment_method';

    /**
     * The Stripe model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $owner;

    /**
     * The Stripe PaymentMethod instance.
     *
     * @var \Stripe\PaymentMethod
     */
    protected $paymentMethod;

    /**
     * Create a new PaymentMethod instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $owner
     * @param \Stripe\PaymentMethod               $paymentMethod
     *
     * @return void
     *
     * @throws \App\Exceptions\InvalidPaymentMethodException
     */
    public function __construct(Model $owner, StripePaymentMethod $paymentMethod)
    {
        $this->isOwner($owner, $paymentMethod, InvalidPaymentMethodException::class);

        $this->owner = $owner;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Delete the payment method.
     *
     * @return \Stripe\PaymentMethod
     */
    public function delete(): StripePaymentMethod
    {
        return $this->owner->removePaymentMethod($this->paymentMethod);
    }

    /**
     * Get the Stripe model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function owner(): Model
    {
        return $this->owner;
    }

    /**
     * Get the Stripe PaymentMethod instance.
     *
     * @return \Stripe\PaymentMethod
     */
    public function asStripePaymentMethod(): StripePaymentMethod
    {
        return $this->paymentMethod;
    }

    /**
     * Dynamically get values from the Stripe PaymentMethod.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->paymentMethod->{$key};
    }
}
