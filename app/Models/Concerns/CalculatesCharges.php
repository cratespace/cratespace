<?php

namespace App\Models\Concerns;

use App\Models\Order;

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
     * Caluculate charges to be set.
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    protected static function calculateCharges(Order $order): void
    {
        $order->price = $order->space->getPriceInCents();
        $order->tax = $order->space->getTaxInCents();
        $order->service = $order->getServiceCharge();
    }
}
