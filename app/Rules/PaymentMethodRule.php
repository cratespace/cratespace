<?php

namespace App\Rules;

use Throwable;
use App\Services\Stripe\PaymentMethod;
use Illuminate\Contracts\Validation\Rule;

class PaymentMethodRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            return ! is_null(PaymentMethod::getStripeObject($value));
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The payment method provided is invalid.';
    }
}
