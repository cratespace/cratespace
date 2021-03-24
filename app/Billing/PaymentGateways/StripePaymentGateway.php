<?php

namespace App\Billing\PaymentGateways;

use Throwable;
use App\Support\Money;
use App\Facades\Stripe;
use App\Events\PaymentFailed;
use InvalidArgumentException;
use App\Services\Stripe\Payment;
use App\Events\PaymentSuccessful;
use App\Services\Stripe\Customer;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\InvalidCustomerException;

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
        $customer = $this->getCustomer($details);

        try {
            $payment = Payment::create([
                'amount' => (int) $amount,
                'currency' => Money::preferredCurrency(),
                'customer' => $customer->id,
                'payment_method' => $details['payment_method'],
                'receipt_email' => $customer->email,
                'description' => 'Cratespace purchase',
                'metadata' => [
                    'product' => $this->getProductDetails($details),
                ],
                'confirm' => (bool) $details['confirm'] ?? true,
            ], $options);
        } catch (Throwable $e) {
            Stripe::logger()->error($e->getMessage());

            PaymentFailed::dispatch(array_merge($details, [
                'context' => $e->getMessage(),
            ]));

            return false;
        }

        $payment->validate();

        if ($payment->isSucceeded()) {
            $this->successful = true;

            PaymentSuccessful::dispatch($payment);
        }

        return $payment;
    }

    /**
     * Get instance of Stripe customer.
     *
     * @return \App\Services\Stripe\Customer
     */
    public function getCustomer(array $details): Customer
    {
        $stripeId = $details['customer'] ?? Auth::user()->customerId();

        if (is_null($stripeId)) {
            throw new InvalidCustomerException('User is not a valid Stripe customer');
        }

        return new Customer($stripeId);
    }

    /**
     * Get product details.
     *
     * @param array $details
     *
     * @return array
     */
    public function getProductDetails(array $details): array
    {
        if (! isset($details['product'])) {
            throw new InvalidArgumentException('Product details not set');
        }

        return $details['product'];
    }
}
