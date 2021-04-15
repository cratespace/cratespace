<?php

namespace App\Contracts\Orders;

interface ConfirmationNumberGenerator
{
    /**
     * Generate order confirmation number.
     *
     * @return string
     */
    public function generate(): string;
}
