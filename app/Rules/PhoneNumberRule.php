<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumberRule extends RegexRule implements Rule
{
    /**
     * The value pattern to compare against.
     *
     * @var string
     */
    protected static $pattern = '/(0)([1-9]{1})([0-9]{8})/';

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
        return 'Phone number should match this pattern 07xxxxxxxx.';
    }
}
