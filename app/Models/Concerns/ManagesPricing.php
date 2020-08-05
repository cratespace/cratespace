<?php

namespace App\Models\Concerns;

use App\Support\Formatter;

trait ManagesPricing
{
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
     * Set the space's price in cents.
     *
     * @param string $value
     *
     * @return string
     */
    public function setTaxAttribute($value)
    {
        $this->attributes['tax'] = $value * 100;
    }

    /**
     * Get the space's tax amount.
     *
     * @param string $value
     *
     * @return string
     */
    public function getTaxAttribute($value)
    {
        return Formatter::money($value);
    }

    /**
     * Get price as integer and in cents.
     *
     * @return int
     */
    public function getPriceInCents(): int
    {
        return $this->getChargeAmountInCents($this->price);
    }

    /**
     * Get tax as integer and in cents.
     *
     * @return int
     */
    public function getTaxInCents(): int
    {
        return $this->getChargeAmountInCents($this->tax);
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
