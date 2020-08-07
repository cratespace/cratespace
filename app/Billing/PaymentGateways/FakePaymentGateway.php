<?php

namespace App\Billing\PaymentGateways;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Support\Facades\Crypt;
use App\Exceptions\PaymentFailedException;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class FakePaymentGateway implements PaymentGatewayContract
{
    /**
     * Total charge amount.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * All registered tokens.
     *
     * @var array
     */
    protected $tokens;

    /**
     * Get total amount the customer is charged.
     *
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * Charge the customer with the given amount.
     *
     * @param int         $amount
     * @param string      $paymentToken
     * @param string|null $destinationAccountId
     *
     * @return void
     */
    public function charge(int $amount, string $paymentToken, ?string $destinationAccountId = null): void
    {
        if (!$this->validPaymentToken($paymentToken)) {
            throw new PaymentFailedException("Token {$paymentToken} is invalid", $amount);
        }

        $this->total = $amount;
    }

    protected function validPaymentToken(string $token)
    {
        if (Str::contains($token, 'fake-tok_')) {
            return Arr::has($this->tokens, $token);
        }

        return false;
    }

    /**
     * Generate payment token.
     *
     * @param array $card
     *
     * @return string
     */
    public function generateToken(array $card): string
    {
        if (is_null($card['number'])) {
            throw new InvalidArgumentException('Card number not found');
        }

        $token = 'fake-tok_' . Crypt::encrypt($card['number']);

        $this->tokens[$token] = $card['number'];

        return $token;
    }
}
