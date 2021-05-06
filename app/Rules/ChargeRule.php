<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ChargeRule extends RegexRule implements Rule
{
    /**
     * The value pattern to compare against.
     *
     * @var string
     */
    protected static $pattern = '/^\d+(\.\d{1,2})?$/';

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
        return (bool) preg_match(static::$pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
