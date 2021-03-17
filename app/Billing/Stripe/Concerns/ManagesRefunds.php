<?php

namespace App\Billing\Stripe\Concerns;

use Stripe\Refund;
use Stripe\Service\RefundService;
use Illuminate\Support\Collection;

trait ManagesRefunds
{
    /**
     * Get a list of Refunds.
     *
     * @param array|null $filters
     *
     * @return \Illuminate\Support\Collection
     */
    public function allRefunds(?array $filters = null): Collection
    {
        return collect($this->refund()->all($filters));
    }

    /**
     * Retrieves the details of a Refund that has previously been created.
     *
     * @param string $id
     *
     * @return \Stripe\Refund
     */
    public function getRefund(string $id): ?Refund
    {
        return $this->refund()->retrieve($id);
    }

    /**
     * Creates a Refund object.
     *
     * @param array      $details
     * @param array|null $options
     *
     * @return \Stripe\Refund
     */
    public function createRefund(array $details, ?array $options = null): Refund
    {
        return $this->refund()->create($details, $options);
    }

    /**
     * Updates properties on a Refund object without confirming.
     *
     * @param string     $id
     * @param array      $details
     * @param array|null $options
     *
     * @return \Stripe\Refund
     */
    public function updateRefund(string $id, array $details, ?array $options = null): Refund
    {
        return $this->refund()->update($id, $details, $options);
    }

    /**
     * Get instance of Stripe payment intent service.
     *
     * @return \Stripe\Service\RefundService
     */
    public function refund(): RefundService
    {
        return $this->client()->refunds;
    }
}
