<?php

namespace App\Rules;

use App\Contracts\Products\Finder;
use Illuminate\Contracts\Validation\Rule;

class ProductRule implements Rule
{
    /**
     * The product finder instance.
     *
     * @var \App\Contracts\Products\Finder
     */
    protected $finder;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

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
        return $this->finder->exists($value);
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
