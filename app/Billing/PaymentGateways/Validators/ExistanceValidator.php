<?php

namespace App\Billing\PaymentGateways\Validators;

use Illuminate\Support\Facades\Crypt;
use App\Contracts\Support\Validator as ValidatorContract;

class ExistenceValidator implements ValidatorContract
{
    /**
     * Determine if the given item passes the given statndards.
     *
     * @param mixed $item
     * @param mixed $standard
     *
     * @return bool
     */
    public function validate($item, $standard): bool
    {
        $cardNumber = Crypt::decryptString(str_replace($standard->prefix(), '', $item));

        if (!in_array($cardNumber, $standard->tokens())) {
            return false;
        }

        return true;
    }
}
