<?php

namespace App\Billing\Token;

class DestroyPaymentToken extends PaymentToken
{
    /**
     * Delete the given payment token.
     *
     * @param string $token
     *
     * @return void
     */
    public function destroy(string $token): void
    {
        $this->getToken($token)->delete();
    }
}
