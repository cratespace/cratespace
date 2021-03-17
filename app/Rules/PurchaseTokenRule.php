<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Actions\Purchases\ValidatePurchaseToken;

class PurchaseTokenRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(ValidatePurchaseToken $validator)
    {
        $this->validator = $validator;
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
        return $this->validator->validate($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is invalid.';
    }
}
