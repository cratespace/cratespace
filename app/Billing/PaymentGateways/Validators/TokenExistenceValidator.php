<?php

namespace App\Billing\PaymentGateways\Validators;

use Illuminate\Support\Arr;
use App\Contracts\Support\Validator as ValidatorContract;

class TokenExistenceValidator implements ValidatorContract
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
        if (!Arr::has($options['gateway']->tokens(), $item)) {
            return false;
        }

        return true;
    }
}
