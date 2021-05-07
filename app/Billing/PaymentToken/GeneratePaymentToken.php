<?php

namespace App\Billing\PaymentToken;

use App\Contracts\Products\Product;
use Illuminate\Support\Facades\Hash;

class GeneratePaymentToken extends PaymentToken
{
    /**
     * Generate a new payment token.
     *
     * @param \App\Contracts\Billing\Product $product
     *
     * @return string
     */
    public function generate(Product $product): string
    {
        $token = $this->tokens->create([
            'name' => $product->getCode(),
            'token' => Hash::make($product->getCode()),
        ]);

        return $token->token;
    }
}
