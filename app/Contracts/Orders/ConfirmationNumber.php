<?php

namespace App\Contracts\Orders;

interface ConfirmationNumber extends ConfirmationNumberValidator
{
    /**
     * Generate order confirmation number.
     *
     * @return string
     */
    public function generate(): string;
}
