<?php

namespace App\Actions\Customer;

use App\Contracts\Billing\Product;
use App\Contracts\Actions\MakesPurchases;
use App\Billing\PaymentGateways\PaymentGateway;

class MakePurchase implements MakesPurchases
{
    /**
     * The PaymentGateway instance.
     *
     * @var \App\Billing\PaymentGateways\PaymentGateway
     */
    protected $paymentGateway;

    /**
     * Create new instance of MakePurchase action class.
     *
     * @param \App\Billing\PaymentGateways\PaymentGateway $paymentGateway
     *
     * @return void
     */
    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Purchase the given product using the given details.
     *
     * @param \App\Contracts\Billing\Product $product
     * @param array                          $details
     *
     * @return mixed
     */
    public function purchase(Product $product, array $details)
    {
        $payment = $this->paymentGateway->charge(
            $product->fullAmount(),
            $this->attachMetaDetails($product, $details)
        );

        return $product->placeOrder($payment);
    }

    /**
     * Attach details about product and merchant.
     *
     * @param \App\Contracts\Billing\Product $product
     * @param array                          $details
     *
     * @return array
     */
    protected function attachMetaDetails(Product $product, array $details): array
    {
        return array_merge($details, [
            'metadata' => [
                'product_code' => $product->code(),
                'merchant_registration_number' => $product->merchant()->registration_number,
            ],
        ]);
    }
}
