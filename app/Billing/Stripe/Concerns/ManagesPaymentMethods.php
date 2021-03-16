<?php

namespace App\Billing\Stripe\Concerns;

use Stripe\PaymentMethod;
use Illuminate\Support\Collection;
use Stripe\Service\PaymentMethodService;

trait ManagesPaymentMethods
{
    /**
     * Get a list of PaymentMethods.
     *
     * @param array|null $filters
     *
     * @return \Illuminate\Support\Collection
     */
    public function allMethods(?array $filters = null): Collection
    {
        return collect($this->methods()->all($filters));
    }

    /**
     * Retrieves the details of a PaymentMethod that has previously been created.
     *
     * @param string $id
     *
     * @return \Stripe\PaymentMethod
     */
    public function getMethod(string $id): ?PaymentMethod
    {
        return $this->methods()->retrieve($id);
    }

    /**
     * Creates a PaymentMethod object.
     *
     * @param array      $details
     * @param array|null $options
     *
     * @return \Stripe\PaymentMethod
     */
    public function createMethod(array $details, ?array $options = null): PaymentMethod
    {
        return $this->methods()->create($details, $options);
    }

    /**
     * Updates properties on a PaymentMethod object without confirming.
     *
     * @param string     $id
     * @param array      $details
     * @param array|null $options
     *
     * @return \Stripe\PaymentMethod
     */
    public function updateMethod(string $id, array $details, ?array $options = null): PaymentMethod
    {
        return $this->methods()->update($id, $details, $options);
    }

    /**
     * Get instance of Stripe payment intent service.
     *
     * @return \Stripe\Service\PaymentMethodService
     */
    public function methods(): PaymentMethodService
    {
        return $this->client()->paymentMethods;
    }
}
