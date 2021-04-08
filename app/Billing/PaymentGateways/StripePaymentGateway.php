<?php

namespace App\Billing\PaymentGateways;

use Throwable;
use App\Support\Money;
use App\Facades\Stripe;
use App\Events\PaymentFailed;
use App\Services\Stripe\Payment;
use App\Events\PaymentSuccessful;
use App\Services\Stripe\Customer;
use App\Services\Stripe\Resource;
use App\Exceptions\PaymentFailedException;

class StripePaymentGateway extends PaymentGateway
{
    /**
     * Charge the customer the given amount.
     *
     * @param int        $amount
     * @param array      $details
     * @param array|null $options
     *
     * @return mixed
     *
     * @throws \App\Exceptions\PaymentFailedException
     */
    public function charge(int $amount, array $details, ?array $options = null)
    {
        if (! is_null(static::$beforeFirstChargeCallback)) {
            $callback = static::$beforeFirstChargeCallback;

            static::useBeforeFirstCharge(null);

            call_user_func($callback, $this);
        }

        $customer = $this->getCustomer($details['customer']);

        try {
            $payment = Payment::create($this->defaultOptions([
                'amount' => (int) $amount,
                'customer' => $customer->id,
                'payment_method' => $details['payment_method'],
                'receipt_email' => $customer->email,
                'metadata' => $details['metadata'],
            ]), $options);
        } catch (Throwable $e) {
            Stripe::logger()->error($message = $e->getMessage());

            PaymentFailed::dispatch(array_merge($details, [
                'context' => $message,
            ]));

            throw new PaymentFailedException(null, $message);
        }

        $payment->validate();

        if ($payment->isSucceeded()) {
            $this->successful = true;

            PaymentSuccessful::dispatch($payment);
        }

        return $payment;
    }

    /**
     * Get Stripe customer instance.
     *
     * @param string $id
     *
     * @return \App\Services\Stripe\Resource
     */
    public function getCustomer(string $id): Resource
    {
        return new Customer($id);
    }

    public function defaultOptions(array $overrides = []): array
    {
        return array_merge([
            'currency' => Money::preferredCurrency(),
            'description' => 'Cratespace purchase',
            'confirm' => true,
            'confirmation_method' => 'automatic',
        ], $overrides);
    }
}
