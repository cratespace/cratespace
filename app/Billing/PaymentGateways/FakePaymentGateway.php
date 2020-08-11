<?php

namespace App\Billing\PaymentGateways;

use Closure;
use App\Models\Order;
use InvalidArgumentException;
use App\Billing\Charges\Charge;
use Illuminate\Support\Facades\Crypt;
use App\Exceptions\PaymentFailedException;
use App\Billing\PaymentGateways\Validators\CardValidator;
use App\Billing\PaymentGateways\Validators\FormatValidator;
use App\Billing\PaymentGateways\Validators\ExistenceValidator;
use App\Contracts\Billing\PaymentGateway as PaymentGatewayContract;

class FakePaymentGateway extends PaymentGateway implements PaymentGatewayContract
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
     * Payment token validators.
     *
     * @var array
     */
    protected static $validators;

    /**
     * Test credit card number.
     */
    public const TEST_CARD_NUMBER = '4242424242424242';

    /**
     * Payment token prefix.
     *
     * @param string $key
     */
    protected $prefix = 'fake-tok_';

    /**
     * Call back to run as a hook before the first charge.
     *
     * @var \Closure
     */
    protected $beforeFirstChargeCallback;

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
     * @param \App\Models\Order $order
     * @param string            $paymentToken
     *
     * @return void
     */
    public function charge(Order $order, string $paymentToken): void
    {
        // $this->runBeforeChargesCallback();

        if (!$this->matches($paymentToken)) {
            throw new PaymentFailedException("Token {$paymentToken} is invalid", $order->total);
        }

        $this->createCharge($order, $paymentToken);

        $this->total = $order->total;
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
            if (!$validator->validate($token, ['gateway' => $this])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Run a callback that has been set before original charge should be performed.
     *
     * @return void
     */
    protected function runBeforeChargesCallback(): void
    {
        if ($this->beforeFirstChargeCallback !== null) {
            $callback = $this->beforeFirstChargeCallback;

            $this->beforeFirstChargeCallback = null;

            call_user_func_array($callback, [$this]);
        }
    }

    /**
     * Set a call back to run as a hook before the first charge.
     *
     * @param \Closure $callback
     *
     * @return void
     */
    public function beforeFirstCharge(Closure $callback): void
    {
        $this->beforeFirstChargeCallback = $callback;
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
