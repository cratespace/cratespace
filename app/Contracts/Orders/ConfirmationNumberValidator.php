<?php

namespace App\Contracts\Orders;

interface ConfirmationNumberValidator
{
    /**
     * Validate the given order confirmation number.
     *
     * @param string $confirmationNumber
     *
     * @return bool
     */
    public function validate(string $confirmationNumber): bool;
}
