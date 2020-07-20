<?php

namespace App\Models\Concerns;

use App\Support\Formatter;

trait ManagesPricing
{
    /**
     * Set the space's price in cents.
     *
     * @param string $value
     *
     * @return string
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }

    /**
     * Get the space's price.
     *
     * @param string $value
     *
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return Formatter::moneyFormat($value);
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
        return Formatter::moneyFormat($value);
    }

    /**
     * Get price as integer and in cents.
     *
     * @return int
     */
    public function getPriceInCents(): int
    {
        return Formatter::getIntegerValues($this->price);
    }

    /**
     * Get tax as integer and in cents.
     *
     * @return int
     */
    public function getTaxInCents(): int
    {
        return Formatter::getIntegerValues($this->tax);
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
