<?php

namespace App\Billing\PaymentGateways\Validators;

use Illuminate\Support\Arr;
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
        if (!Arr::has($standard->tokens(), $item)) {
            return false;
        }

        return true;
    }
}
