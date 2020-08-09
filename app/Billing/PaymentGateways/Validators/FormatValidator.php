<?php

namespace App\Billing\PaymentGateways\Validators;

use Illuminate\Support\Str;
use App\Contracts\Support\Validator as ValidatorContract;

class FormatValidator implements ValidatorContract
{
    /**
     * Determine if the given item passes the given standards.
     *
     * @param mixed      $item
     * @param array|null $options
     *
     * @return bool
     */
    public function validate($item, ?array $options = null): bool
    {
        if (!Str::contains($item, $options['gateway']->prefix())) {
            return false;
        }

        return true;
    }
}
