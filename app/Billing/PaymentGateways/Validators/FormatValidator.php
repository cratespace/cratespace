<?php

namespace App\Billing\PaymentGateways\Validators;

use Illuminate\Support\Str;
use App\Contracts\Support\Validator as ValidatorContract;

class FormatValidator implements ValidatorContract
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
        if (!Str::contains($item, $standard)) {
            return false;
        }

        return true;
    }
}
