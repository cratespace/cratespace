<?php

namespace App\Billing\Gateways;

use Throwable;
use App\Support\Money;
use App\Facades\Stripe;
use App\Events\PaymentFailed;
use App\Events\PaymentSuccessful;
use App\Services\Stripe\Customer;
use App\Services\Stripe\Resource;
use App\Contracts\Billing\Payment;
use App\Exceptions\PaymentFailedException;
use App\Services\Stripe\Payment as StripePayment;

class StripePaymentGateway extends PaymentGateway
{
    /**
     * Charge the customer the given amount.
     *
     * @param int        $amount
     * @param array      $details
     * @param array|null $options
     *
     * @return \App\Contracts\Billing\Payment
     */
    public function charge(int $amount, array $details, ?array $options = null): Payment
    {
        $customer = $this->getCustomer($details['customer']);

        try {
            $payment = StripePayment::create($this->defaultOptions([
                'amount' => (int) $amount,
                'customer' => $customer->id,
                'payment_method' => $details['payment_method'],
                'receipt_email' => $customer->email,
                'metadata' => [
                    'product' => $details['product'],
                ],
            ]), $options);
        } catch (Throwable $e) {
            Stripe::logger()->error($message = $e->getMessage());

            PaymentFailed::dispatch(null, json_encode(
                array_merge($details, ['context' => $message]
            )));

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

    /**
     * Default Stripe payment options.
     *
     * @param array $overrides
     *
     * @return array
     */
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
