<?php

namespace App\Orders\Validators;

use App\Contracts\Orders\ConfirmationNumberValidator;

class CharacterValidator implements ConfirmationNumberValidator
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
        return (bool) \preg_match('/^[A-Z0-9]+$/', $confirmationNumber);
    }
}
