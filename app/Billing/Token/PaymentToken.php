<?php

namespace App\Billing\Token;

use App\Models\PaymentToken as PaymentTokenModel;

abstract class PaymentToken
{
    /**
     * The payment token model instance.
     *
     * @var \App\Models\PaymentToken]
     */
    protected $tokens;

    /**
     * Create new instance of PaymentToken action class.
     *
     * @param \App\Models\PaymentToken $tokens
     *
     * @return void
     */
    public function __construct(PaymentTokenModel $tokens)
    {
        $this->tokens = $tokens;
    }

    /**
     * Get the token using the token code provided.
     *
     * @param string $token
     *
     * @return \App\Models\PaymentToken|null
     */
    public function getToken(string $token): ?PaymentTokenModel
    {
        return $this->tokens->whereToken($token)->first();
    }
}
