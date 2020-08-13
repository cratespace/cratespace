<?php

namespace App\Billing\PaymentGateways;

use Closure;
use App\Models\Order;
use App\Models\Charge;
use App\Events\OrderPlaced;
use App\Events\SuccessfullyCharged;
use App\Billing\PaymentGateways\Validators\CardValidator;
use App\Billing\PaymentGateways\Validators\FormatValidator;
use App\Billing\PaymentGateways\Validators\TokenExistenceValidator;

abstract class PaymentGateway
{
    /**
     * Test credit card number.
     */
    public const TEST_CARD_NUMBER = '4242424242424242';

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
     * Payment token prefix.
     *
     * @param string $key
     */
    protected $prefix;

    /**
     * Call back to run as a hook before the first charge.
     *
     * @var \Closure
     */
    protected $beforeFirstChargeCallback;

    /**
     * Payment token validators.
     *
     * @var array
     */
    protected static $validators;

    /**
     * Save charge details to database.
     *
     * @param \App\Models\Order $order
     * @param string            $paymentToken
     * @param array|null        $details
     *
     * @return \App\Models\Charge
     */
    public function createCharge(Order $order, string $paymentToken, ?array $details = null): Charge
    {
        $this->fireSuccessfulChargeEvent($order);

        $this->fireOrderPlacedEvent($order);

        return $order->createCharge([
            'amount' => $order->total,
            'card_last_four' => substr($this->tokens[$paymentToken], -4),
            'details' => $details ?? 'local',
        ]);
    }

    /**
     * Fire event "successfully charged".
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    protected function fireSuccessfulChargeEvent(Order $order): void
    {
        event(new SuccessfullyCharged($order));
    }

    /**
     * Fire event "successfully charged".
     *
     * @param \App\Models\Order $order
     *
     * @return void
     */
    protected function fireOrderPlacedEvent(Order $order): void
    {
        event(new OrderPlaced($order));
    }

    /**
     * Run a callback that has been set before original charge should be performed.
     *
     * @return mixed
     */
    protected function runBeforeChargesCallback()
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
     * Get all registered payment tokens.
     *
     * @return array
     */
    public function tokens(): array
    {
        return $this->tokens;
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
     * Match the given payment token.
     *
     * @param string $token
     *
     * @return bool
     */
    public function matches(string $token): bool
    {
        foreach ($this->getValidators() as $validator) {
            if (is_string($validator)) {
                $validator = app()->make($validator);
            }

            if (!$validator->validate($token, ['gateway' => $this])) {
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
    public static function getValidators(): array
    {
        if (isset(static::$validators)) {
            return static::$validators;
        }

        return static::$validators = [
            FormatValidator::class,
            CardValidator::class,
            TokenExistenceValidator::class,
        ];
    }
}
