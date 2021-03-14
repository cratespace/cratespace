<?php

namespace App\Actions\Purchases;

use Throwable;
use App\Models\Charge;
use App\Contracts\Purchases\Product;
use Illuminate\Support\Facades\Auth;
use App\Contracts\Actions\MakesPurchase;
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
        try {
            $payment = $this->paymentGateway->charge(
                $product->fullPrice(),
                $details['payment_method'],
                ['customer' => $this->getCustomer($details)]
            );
        } catch (Throwable $e) {
            $this->saveChargeDetails($product, $details, true);

            throw $e;
        }

        $this->saveChargeDetails($product, $payment->toArray());

        return $product->purchase($details);
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
     *
     * @return void
     */
    protected function saveChargeDetails(Product $product, array $details, bool $failed = false): void
    {
        Charge::create([
            'product_id' => $product->id,
            'details' => json_encode($details),
            'status' => $failed ? 'failed' : 'successful',
        ]);
    }
}
