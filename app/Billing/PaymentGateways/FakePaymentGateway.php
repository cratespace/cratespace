<?php

namespace App\Billing\PaymentGateways;

use InvalidArgumentException;
use Illuminate\Support\Facades\Crypt;
use App\Exceptions\PaymentFailedException;
use App\Billing\PaymentGateways\Validators\CardValidator;
use App\Billing\PaymentGateways\Validators\FormatValidator;
use App\Billing\PaymentGateways\Validators\ExistenceValidator;
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
     * Application encryption key.
     *
     * @var string
     */
    protected $key;

    /**
     * Payment token validators.
     *
     * @var array
     */
    protected static $validators;

    /**
     * Payment token prefix.
     *
     * @param string $key
     */
    protected $prefix = 'fake-tok_';

    /**
     * Create new instance of fake payment token.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

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
        if (!$this->matches($paymentToken)) {
            throw new PaymentFailedException("Token {$paymentToken} is invalid", $amount);
        }

        $this->total = $amount;
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

        $token = $this->prefix . Crypt::encryptString($card['number']);

        $this->tokens[$token] = $card['number'];

        return $token;
    }

    /**
     * Match the given payment token.
     *
     * @param string $token
     *
     * @return bool
     */
    public function matches(string $token): bool
    {
        foreach ($this->getValidators() as $validator) {
            if (!$validator->validate($token, $this)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the route validators for the instance.
     *
     * @return array
     */
    public static function getValidators()
    {
        if (isset(static::$validators)) {
            return static::$validators;
        }

        return static::$validators = [
            new FormatValidator(),
            new CardValidator(),
            new ExistenceValidator(),
        ];
    }

    /**
     * Get payment token prefix.
     *
     * @return string
     */
    public function prefix(): string
    {
        return $this->prefix;
    }

    /**
     * Get all registered paymnet tokens.
     *
     * @return array
     */
    public function tokens(): array
    {
        return $this->tokens;
    }
}
