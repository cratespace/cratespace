<?php

namespace App\Billing\PaymentGateways\Validators;

use Illuminate\Support\Facades\Crypt;
use App\Contracts\Support\Validator as ValidatorContract;

class CardValidator implements ValidatorContract
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
        $cardNumber = Crypt::decryptString(str_replace($options['gateway']->prefix(), '', $item));

        if (!in_array($cardNumber, $options['gateway']->tokens())) {
            return false;
        }

        return true;
    }
}
