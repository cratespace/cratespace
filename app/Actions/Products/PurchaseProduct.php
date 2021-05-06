<?php

namespace App\Actions\Products;

use App\Contracts\Billing\Payment;
use App\Contracts\Products\Product;
use App\Contracts\Billing\MakesPurchases;
use App\Billing\PaymentGateways\PaymentGateway;

class PurchaseProduct implements MakesPurchases
{
    /**
     * The PaymentGateway instance.
     *
     * @var \App\Billing\PaymentGateways\PaymentGateway
     */
    protected $paymentGateway;

    /**
     * Create new instance of PurchaseProduct action class.
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
     * Makes a purchase.
     *
     * @param \App\Contracts\Products\Product $product
     * @param array                           $details
     *
     * @return mixed
     */
    public function purchase(Product $product, array $details)
    {
        $payment = $this->charge($product, $details);

        return $product->placeOrder($payment);
    }

    /**
     * Charge the given product using the given details.
     *
     * @param \App\Contracts\Products\Product $product
     * @param array                           $details
     *
     * @return \App\Contracts\Billing\Payment
     */
    protected function charge(Product $product, array $details): Payment
    {
        return $this->paymentGateway->charge($product->rawAmount(), $details);
    }
}
