<?php

namespace App\Billing\Payments;

use Illuminate\Support\Str;
use App\Exceptions\InvalidPaymentTokenException;

class FakeGateway extends Gateway
{
    /**
     * Indicates whether the charge was successfully processed.
     *
     * @var bool
     */
    protected $chargeSuccessful = false;

    /**
     * All charge amounts.
     *
     * @var array
     */
    protected $charges = [];

    /**
     * Payment token of current instance.
     *
     * @var string
     */
    protected $token;

    /**
     * Create new instance of fake payment gateway.
     *
     * @return void
     */
    public function __construct()
    {
        $this->charges = collect();
        $this->token = 'crate-' . Str::random(40);
    }

    /**
     * Get sum amount of all charge amounts.
     *
     * @return int
     */
    public function totalCharges(): int
    {
        return $this->charges->sum();
    }

    public function chargeSuccessful(): bool
    {
        return $this->chargeSuccessful;
    }

    /**
     * Attempt charge procedure.
     *
     * @param int    $amount
     * @param string $token
     *
     * @return void
     */
    public function charge(int $amount, string $token): void
    {
        if ($token !== $this->token) {
            throw new InvalidPaymentTokenException("Token [{$token}] is invalid");
        }

        $this->charges[] = $amount;

        $this->chargeSuccessful = true;
    }

    /**
     * Get valid instance of payment token.
     *
     * @return string
     */
    public function getValidToken(): string
    {
        return $this->token;
    }
}
