<?php

namespace App\Actions\Purchases;

use App\Events\PaymentFailed;
use App\Events\PaymentSuccessful;
use Illuminate\Support\Facades\DB;
use App\Contracts\Purchases\Product;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Actions\MakesPurchase;
use App\Exceptions\PaymentFailedException;
use App\Exceptions\InvalidPaymentTokenException;
use App\Billing\Gateways\Gateway as PaymentGateway;

class PurchaseSpace implements MakesPurchase
{
    /**
     * Instance of payment gateway.
     *
     * @var \App\Billing\Gateways\Gateway
     */
    protected $paymentGateway;

    /**
     * Create new instance of purchase space action class.
     *
     * @param \App\Billing\Gateways\Gateway $paymentGateway
     */
    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Purchase given product using the given details.
     *
     * @param \App\Contracts\Purchases\Product $product
     * @param array                            $details
     *
     * @return mixed
     */
    public function purchase(Product $product, array $details)
    {
        $this->validatePurchaseToken($details['purchase_token']);

        $payment = $this->paymentGateway->charge(
            $product->fullPrice(),
            $details['payment_method'],
            $this->setOptions($product, $details)
        );

        if ($this->paymentGateway->isSuccessful()) {
            PaymentSuccessful::dispatch($payment);

            return $product->purchase(
                array_merge($details, ['payment' => $payment->toArray()])
            );
        }

        PaymentFailed::dispatch($payment);

        throw new PaymentFailedException($payment);
    }

    /**
     * Validate and delete current purchase token.
     *
     * @param string $token
     *
     * @return bool
     *
     * @throws \App\Exceptions\InvalidPaymentTokenException
     */
    protected function validatePurchaseToken(string $token): bool
    {
        if (! app(ValidatePurchaseToken::class)->validate($token)) {
            throw new InvalidPaymentTokenException("Purchase token [{$token}] is invalid");
        }

        DB::transaction(function () use ($token) {
            DB::table('purchase_tokens')
                ->where('token', $token)
                ->delete();
        });

        return true;
    }

    /**
     * Set options to be set when creating payment intent.
     *
     * @param \App\Contracts\Purchases\Product $product
     * @param array                            $details
     *
     * @return array
     */
    protected function setOptions(Product $product, array $details): array
    {
        return array_merge(
            $this->getCustomerInformation($details),
            ['metadata' => [
                'businessId' => $product->business('business')->id,
            ]],
        );
    }

    /**
     * Get Stripe customer ID>.
     *
     * @param array $details
     *
     * @return array
     */
    protected function getCustomerInformation(array $details): array
    {
        return [
            'customer' => $details['customer'] ?? Auth::user()->customerId(),
            'receipt_email' => $details['email'] ?? Auth::user()->email,
        ];
    }
}
