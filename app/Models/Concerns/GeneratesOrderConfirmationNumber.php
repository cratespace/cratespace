<?php

namespace App\Models\Concerns;

use Facades\App\Support\UidGenerator;

trait GeneratesOrderConfirmationNumber
{
    /**
     * Boot trait.
     */
    protected static function bootGeneratesOrderConfirmationNumber()
    {
        static::creating(function ($order) {
            $order->confirmation_number = $order->confirmation_number ?? UidGenerator::generate();
        });
    }
}
