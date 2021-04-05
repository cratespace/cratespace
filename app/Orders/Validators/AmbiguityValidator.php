<?php

namespace App\Orders\Validators;

use Illuminate\Support\Str;
use App\Contracts\Orders\ConfirmationNumberValidator;

class AmbiguityValidator implements ConfirmationNumberValidator
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
        foreach ([1, 0, 'I', 'O'] as $charcater) {
            if (Str::contains($confirmationNumber, $charcater)) {
                return false;
            }
        }

        return true;
    }
}
