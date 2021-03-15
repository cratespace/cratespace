<?php

namespace App\Actions\Purchases;

use App\Models\Charge;
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
            ['customer' => $this->getCustomer($details)]
        );

        if ($this->paymentGateway->isSuccessful()) {
            $charge = $this->saveChargeDetails($product, $payment->toArray());

            PaymentSuccessful::dispatch($charge);

            return $product->purchase($details);
        }

        $charge = $this->saveChargeDetails($product, $details, true);

        PaymentFailed::dispatch($charge);

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
     * Get Stripe customer ID>.
     *
     * @param array $details
     *
     * @return string
     */
    protected function getCustomer(array $details): string
    {
        if (! isset($details['customer'])) {
            return Auth::user()->customerId();
        }

        return $details['customer'];
    }

    /**
     * Save charge details to database.
     *
     * @param \App\Contracts\Purchases\Product $product
     * @param array                            $details
     * @param string|null                      $context
     *
     * @return \App\Models\Charge
     */
    protected function saveChargeDetails(Product $product, array $details, bool $failed = false): Charge
    {
        return Charge::create([
            'product_id' => $product->id,
            'user_id' => $product->user_id,
            'customer_id' => Auth::id(),
            'details' => $details,
            'status' => $failed ? 'failed' : 'successful',
        ]);
    }
}
