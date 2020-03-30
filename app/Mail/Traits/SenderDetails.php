<?php

namespace App\Mail\Traits;

trait SenderDetails
{
    /**
     * Get details regarding email sender.
     *
     * @return array
     */
    protected function getSenderDetails()
    {
        return [
            config('emailaddresses.orders.address'),
            config('emailaddresses.orders.name')
        ];
    }
}
