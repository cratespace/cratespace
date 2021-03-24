<?php

namespace App\Billing\PaymentGateways;

use Throwable;
use App\Support\Money;
use App\Facades\Stripe;
use App\Services\Stripe\Payment;
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
        $customer = $this->getCustomer();

        try {
            $payment = Payment::create([
                'amount' => $amount,
                'currency' => Money::preferredCurrency(),
                'customer' => $customer->id,
                'payment_method' => $details['payment_method'],
                'receipt_email' => $customer->email,
                'description' => 'Cratespace purchase',
                'metadata' => [
                    'product' => $this->getProductDetails($details),
                ],
                'confirm' => $details['confirm'] ?? true,
            ], $options);
        } catch (Throwable $e) {
            Stripe::logger()->error($e->getMessage());

            return false;
        }

        $payment->validate();

        if ($payment->isSucceeded()) {
            $this->successful = true;
        }

        return $payment;
    }

    /**
     * Get instance of Stripe customer.
     *
     * @return \App\Services\Stripe\Customer
     */
    public function getCustomer(): Customer
    {
        $user = Auth::user();
        $stripeId = $user->profile->stripe_id;

        if (is_null($stripeId)) {
            throw new InvalidCustomerException("Customer [{$user->name}] is not a valid Stripe customer.");
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
            throw new InvalidArgumentException('Product ID not set.');
        }

        $product = Space::find($details['product']);

        return $product->toArray();
    }
}
