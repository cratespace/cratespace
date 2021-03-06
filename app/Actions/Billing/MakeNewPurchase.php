<?php

namespace App\Actions\Billing;

use App\Contracts\Billing\Payment;
use App\Events\PurchaseSuccessful;
use App\Billing\Token\PaymentToken;
use App\Contracts\Products\Product;
use App\Billing\Gateways\PaymentGateway;
use App\Contracts\Products\FindsProducts;
use App\Billing\Token\DestroyPaymentToken;
use App\Contracts\Billing\MakesNewPurchases;
use Cratespace\Sentinel\Support\Concerns\InteractsWithContainer;

class MakeNewPurchase implements MakesNewPurchases
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
     * @param \App\Billing\Gateways\PaymentGateway $paymentGateway
     *
     * @return void
     */
    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Makes a new purchase.
     *
     * @param \App\Contracts\Products\Product|string $product
     * @param array                                  $details
     *
     * @return mixed
     */
    public function purchase($product, array $details)
    {
        if (is_string($product)) {
            $product = $this->resolve(FindsProducts::class)->find($product);
        }

        $payment = $this->charge($product, array_merge([
            'product' => $product->getCode(),
        ], $details));

        $this->paymentToken()->destroy($details['payment_token']);

        $order = $product->placeOrder($payment);

        PurchaseSuccessful::dispatch($order);

        return $order;
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
