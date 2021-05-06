<?php

namespace App\Orders\Validators;

use App\Orders\AbstractConfirmationNumber;
use App\Contracts\Orders\ConfirmationNumberValidator;

class LengthValidator implements ConfirmationNumberValidator
{
    /**
     * Validate the given order confirmation number.
     *
     * @param string $confirmationNumber
     *
     * @return bool
     */
    public function validate(string $confirmationNumber): bool
    {
        return strlen($confirmationNumber) === AbstractConfirmationNumber::CHARACTER_LENGTH;
    }
}
