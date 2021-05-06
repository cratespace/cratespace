<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class DestinationRule extends RegexRule implements Rule
{
    /**
     * The value pattern to compare against.
     *
     * @var string
     */
    protected static $pattern = '/([a-zA-Z])+( )*([a-zA-Z])*(, )([a-zA-Z])+( )*([a-zA-Z])*/';

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
        if (preg_match(static::$pattern, $value)) {
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
