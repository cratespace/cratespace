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
        return $product->placeOrder(
            $this->paymentGateway->charge($product->fullPrice(), $details)
        );
    }
}
