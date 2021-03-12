<?php

namespace App\Models\Traits;

trait Marketable
{
    /**
     * Get product business details.
     *
     * @param string|null $attribute
     *
     * @return mixed
     */
    public function business(?string $attribute = null)
    {
        if ($this->has('user')) {
            $business = optional($this->user);
        } elseif ($this->has('business')) {
            $business = optional($this->business);
        } else {
            $business = null;
        }

        if (! is_null($attribute) && ! is_null($business)) {
            return $business->{$attribute};
        }

        return $business;
    }

    /**
     * Get full price or product inclusive of all additional charges.
     *
     * @return int
     */
    public function fullPrice(): int
    {
        if (is_null($this->tax)) {
            return $this->price ?? 0.0;
        }

        return $this->price + $this->tax;
    }
}
