<?php

namespace App\Rules;

use App\Contracts\Billing\Product;
use Illuminate\Contracts\Validation\Rule;

class ProductRule implements Rule
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
        if ($value instanceof Product) {
            return $value->available();
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This product is unavailable at the moment.';
    }
}
