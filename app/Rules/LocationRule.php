<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class LocationRule implements Rule
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
        if (preg_match('/([a-zA-Z])+( )*([a-zA-Z])*(, )([a-zA-Z])+( )*([a-zA-Z])*/', $value)) {
            return Str::contains($value, ',');
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
        return 'Location must be city and country seperated by a comma.';
    }
}
