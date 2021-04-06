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
use App\Contracts\Billing\Product;
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
     */
    public function charge(int $amount, array $details, ?array $options = null)
    {
        $customer = $this->getCustomer($details['customer']);

        try {
            $payment = Payment::create([
                'amount' => (int) $amount,
                'currency' => Money::preferredCurrency(),
                'customer' => $customer->id,
                'payment_method' => $details['payment_method'],
                'receipt_email' => $customer->email,
                'description' => 'Cratespace purchase',
                'metadata' => $details['metadata'],
                'confirm' => true,
                'confirmation_method' => 'automatic',
            ], $options);
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
     * Generate valid test payment token.
     *
     * @param \App\Contracts\Billing\Product|null $product
     *
     * @return string
     */
    public function getValidTestToken(?Product $product = null): string
    {
        return $this->createTokenGenerator()->generate($product);
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
}
