<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Billing\PaymentTokens\ValidatePaymentToken;

class PaymentTokenRule implements Rule
{
    /**
     * The payment token validator instance.
     *
     * @var \App\Billing\PaymentTokens\ValidatePaymentToken
     */
    protected $tokenValidator;

    /**
     * Create a new rule instance.
     *
     * @param \App\Billing\PaymentTokens\ValidatePaymentToken $tokenValidator
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
