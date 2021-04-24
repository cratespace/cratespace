<?php

namespace App\Billing\PaymentTokens;

use App\Contracts\Products\Product;
use Illuminate\Support\Facades\Hash;

class GeneratePaymentToken extends PaymentToken
{
    /**
     * Generate a new payment token.
     *
     * @param \App\Contracts\Products\Product $product
     *
     * @return string
     */
    public function generate(Product $product): string
    {
        $token = $this->tokens->create([
            'name' => $product->code(),
            'token' => Hash::make($product->code()),
        ]);

        return $token->token;
    }
}
