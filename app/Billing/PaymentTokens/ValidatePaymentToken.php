<?php

namespace App\Billing\PaymentTokens;

use Illuminate\Support\Facades\Hash;

class ValidatePaymentToken extends PaymentToken
{
    /**
     * Validate the given token.
     *
     * @param string $token
     *
     * @return bool
     */
    public function validate(string $token): bool
    {
        $tokenEntity = $this->getToken($token);

        if (! is_null($tokenEntity)) {
            return Hash::check($tokenEntity->name, $token);
        }

        return false;
    }
}
