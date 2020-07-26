<?php

namespace App\Models\Concerns;

trait FindsBusiness
{
    /**
     * Boot find business trait.
     */
    protected static function bootFindsBusiness()
    {
        // Associate order to the relevant business.
        static::creating(function ($order) {
            $order->user_id = $order->space->user_id;
        });
    }
}
