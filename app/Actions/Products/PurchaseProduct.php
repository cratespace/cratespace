<?php

namespace App\Actions\Products;

use App\Contracts\Billing\Payment;
use App\Contracts\Products\Product;
use App\Contracts\Billing\MakesPurchases;
use App\Billing\PaymentToken\PaymentToken;
use App\Billing\PaymentGateways\PaymentGateway;
use App\Billing\PaymentToken\DestroyPaymentToken;
use Cratespace\Sentinel\Support\Concerns\InteractsWithContainer;

class PurchaseProduct implements MakesPurchases
{
    use InteractsWithContainer;

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

        $this->paymentToken()->destroy($details['payment_token']);

        $order = $product->placeOrder($payment);
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

    /**
     * Payment token manager.
     *
     * @return \App\Billing\PaymentToken\PaymentToken
     */
    protected function paymentToken(): PaymentToken
    {
        return $this->resolve(DestroyPaymentToken::class);
    }
}
