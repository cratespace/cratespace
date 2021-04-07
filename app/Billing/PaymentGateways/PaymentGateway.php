<?php

namespace App\Billing\PaymentGateways;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

abstract class PaymentGateway
{
    /**
     * List of generated payment tokens.
     *
     * @var array
     */
    protected $tokens = [];

    /**
     * Indicate if the charge was performed successfully.
     *
     * @var bool
     */
    protected $successful = false;

    /**
     * The callback to run before the first charge.
     *
     * @var \Closure
     */
    protected static $beforeFirstChargeCallback;

    /**
     * Charge the customer the given amount.
     *
     * @param int        $amount
     * @param array      $details
     * @param array|null $options
     *
     * @return mixed
     */
    abstract public function charge(int $amount, array $details, ?array $options = null);

    /**
     * Generate a valid token used only for testing.
     *
     * @param string|int|null $encodable
     *
     * @return string
     */
    public function getValidTestToken($encodable = null): string
    {
        $token = ! is_null($encodable)
            ? Crypt::encrypt($encodable)
            : 'fake-tok_' . Str::random(24);

        $this->tokens[] = $token;

        return $token;
    }

    /**
     * Validate the given payment test token.
     *
     * @param string $token
     *
     * @return bool
     */
    public function validateTestToken(string $token): bool
    {
        $decrypted = null;

        try {
            $decrypted = Crypt::decrypt($token);
        } catch (DecryptException $e) {
            if (! Str::contains($token, 'fake-tok_')) {
                return false;
            }
        }

        if (in_array($decrypted ?? $token, $this->tokens)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the charge was succesful.
     *
     * @return bool
     */
    public function successful(): bool
    {
        return $this->successful;
    }

    /**
     * Register a callback that should be run before the initial charge.
     *
     * @param \Closure|null $callback
     *
     * @return void
     */
    public static function useBeforeFirstCharge(?Closure $callback = null): void
    {
        static::$beforeFirstChargeCallback = $callback;
    }
}
