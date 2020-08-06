<?php

namespace App\Models\Concerns;

trait ManagesPricing
{
    /**
     * Get price format for editing.
     *
     * @return int
     */
    public function fullPrice(): int
    {
        return $this->price() + $this->tax();
    }

    /**
     * Get price format for editing.
     *
     * @return int
     */
    public function price(): int
    {
        return $this->getPriceInCents() / 100;
    }

    /**
     * Get tax format for editing.
     *
     * @return int
     */
    public function tax(): int
    {
        return $this->getTaxInCents() / 100;
    }

    /**
     * Get price as integer and in cents.
     *
     * @return int
     */
    public function getPriceInCents(): int
    {
        return $this->getChargeAmountInCents($this->price ?? 0);
    }

    /**
     * Get tax as integer and in cents.
     *
     * @return int
     */
    public function getTaxInCents(): int
    {
        return $this->getChargeAmountInCents($this->tax ?? 0);
    }

    /**
     * Get full price as integer and in cents.
     *
     * @return int
     */
    public function getFullPriceInCents(): int
    {
        return $this->getPriceInCents() + $this->getTaxInCents();
    }
}
