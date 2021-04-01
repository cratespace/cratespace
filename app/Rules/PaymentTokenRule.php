<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Actions\Customer\ValidatePaymentToken;

class PaymentTokenRule implements Rule
{
    /**
     * The payment token validator instance.
     *
     * @var \App\Actions\Customer\ValidatePaymentToken
     */
    protected $tokenValidator;

    /**
     * Create a new rule instance.
     *
     * @param \App\Actions\Customer\ValidatePaymentToken $tokenValidator
     *
     * @return void
     */
    public function __construct(ValidatePaymentToken $tokenValidator)
    {
        $this->tokenValidator = $tokenValidator;
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
        return $this->tokenValidator->validate($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This payment token is invalid.';
    }
}
