<?php

namespace App\Billing\Stripe\Concerns;

use Stripe\Payout;
use Stripe\Service\PayoutService;

trait ManagesPayouts
{
    /**
     * Get all payouts registered to Cratespace.
     *
     * @param array|null $filters
     *
     * @return \Illuminate\Support\Collection
     */
    public function allPayouts(?array $filters = null): Collection
    {
        return collect($this->payouts()->all($filters));
    }

    /**
     * Get the payout with the given ID.
     *
     * @param string $id
     *
     * @return \Stripe\Payout|null
     */
    public function getPayout(string $id): ?Payout
    {
        return $this->payouts()->retrieve($id);
    }

    /**
     * Create new Stripe payout.
     *
     * @param array $data
     *
     * @return \Stripe\Payout
     */
    public function createPayout(array $data): Payout
    {
        return $this->payouts()->create($data);
    }

    /**
     * Update the given payout with the given details.
     *
     * @param string $id
     * @param array  $data
     *
     * @return \Stripe\Payout
     */
    public function updatePayout(string $id, array $data = []): Payout
    {
        return $this->payouts()->update($id, $data);
    }

    /**
     * Delete the given payout.
     *
     * @param string $id
     *
     * @return void
     */
    public function cancelPayout(string $id): void
    {
        $this->payouts()->cancel($id);
    }

    /**
     * Get stripe payout service.
     *
     * @return \Stripe\Service\PayoutService
     */
    public function payouts(): PayoutService
    {
        return $this->client->payouts;
    }
}
