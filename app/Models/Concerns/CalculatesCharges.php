<?php

namespace App\Models\Concerns;

use App\Models\Order;
use App\Exceptions\ChargesNotFountException;

trait CalculatesCharges
{
    /**
     * Boot trait.
     */
    protected static function bootCalculatesCharges()
    {
        static::creating(function ($order) {
            static::calculateCharges($order);
        });
    }

    /**
     * Calculate charges to be set.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    protected static function calculateCharges(Order $order): void
    {
        if (!is_null($order->total)) {
            return;
        }

        foreach (static::getChrages() as $name => $amount) {
            $order->{$name} = $amount;
        }
    }

    /**
     * Get all pre-calculated charges.
     *
     * @return array
     */
    protected static function getChrages(): array
    {
        if (cache()->has('charges')) {
            return cache()->get('charges');
        }

        throw new ChargesNotFountException('Charges have not been calculated');
    }
}
