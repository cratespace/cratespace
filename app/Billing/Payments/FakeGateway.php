<?php

namespace App\Billing\Payments;

use Illuminate\Support\Str;
use App\Exceptions\InvalidPaymentTokenException;

class FakeGateway extends Gateway
{
    protected $chargeSuccessful = false;

    protected $charges = [];

    protected $token;

    public function __construct()
    {
        $this->charges = collect();
        $this->token = 'crate-' . Str::random(40);
    }

    public function totalCharges(): int
    {
        return $this->charges->sum();
    }

    public function chargeSuccessful(): bool
    {
        return $this->chargeSuccessful;
    }

    public function charge(int $amount, string $token)
    {
        if ($token !== $this->token) {
            throw new InvalidPaymentTokenException("Token [{$token}] is invalid");
        }

        $this->charges[] = $amount;

        $this->chargeSuccessful = true;
    }

    public function getValidToken(): string
    {
        return $this->token;
    }
}
