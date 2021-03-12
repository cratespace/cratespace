<?php

namespace App\Billing\Stripe\Concerns;

use Stripe\PaymentIntent;
use Illuminate\Support\Collection;
use Stripe\Service\PaymentIntentService;

trait ManagesPaymentIntents
{
    /**
     * Get a list of PaymentIntents.
     *
     * @param array|null $filters
     *
     * @return \Illuminate\Support\Collection
     */
    public function allIntents(?array $filters = null): Collection
    {
        return collect($this->intents()->all($filters));
    }

    /**
     * Retrieves the details of a PaymentIntent that has previously been created.
     *
     * @param string $id
     *
     * @return \Stripe\PaymentIntent
     */
    public function getIntent(string $id): ?PaymentIntent
    {
        return $this->intents()->retrieve($id);
    }

    /**
     * Creates a PaymentIntent object.
     *
     * @param array      $details
     * @param array|null $options
     *
     * @return \Stripe\PaymentIntent
     */
    public function createIntent(array $details, ?array $options = null): PaymentIntent
    {
        return $this->intents()->create($details, $options);
    }

    /**
     * Updates properties on a PaymentIntent object without confirming.
     *
     * @param string     $id
     * @param array      $details
     * @param array|null $options
     *
     * @return \Stripe\PaymentIntent
     */
    public function updateIntent(string $id, array $details, ?array $options = null): PaymentIntent
    {
        return $this->intents()->update($id, $details, $options);
    }

    /**
     * Confirm that Cratespace customer intends to pay with current or provided payment method.
     *
     * @param string      $id
     * @param string|null $paymentMehod
     * @param array|null  $options
     *
     * @return \Stripe\PaymentIntent
     */
    public function confirmIntent(string $id, ?string $paymentMehod = null, ?array $options = null): PaymentIntent
    {
        return $this->intents()->confirm($id, [
            'payment_method' => $paymentMehod,
        ], $options);
    }

    /**
     * Confirm that Cratespace customer intends to pay with current or provided payment method.
     *
     * @param string      $id
     * @param string|null $reason
     * @param array|null  $options
     *
     * @return \Stripe\PaymentIntent
     */
    public function cancelIntent(string $id, ?string $reason = null, ?array $options = null): PaymentIntent
    {
        return $this->intents()->cancel($id, [
            'cancellation_reason' => $reason,
        ], $options);
    }

    /**
     * Get instance of Stripe payment intent service.
     *
     * @return \Stripe\Service\PaymentIntentService
     */
    public function intents(): PaymentIntentService
    {
        return $this->client()->paymentIntents;
    }
}
