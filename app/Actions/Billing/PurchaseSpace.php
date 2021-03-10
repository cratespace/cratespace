<?php

namespace App\Actions\Billing;

use Throwable;
use App\Models\Charge;
use App\Contracts\Actions\Billing\MakesPurchase;
use App\Billing\Payments\Gateway as PaymentGateway;

class PurchaseSpace implements MakesPurchase
{
    /**
     * Instance of payment gateway.
     *
     * @var \App\Billing\Payments\Gateway
     */
    protected $paymentGateway;

    /**
     * Create new instance of purchase action.
     *
     * @param \App\Billing\Payments\Gateway $paymentGateway
     */
    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Purchase given product using the given details.
     *
     * @param array $details
     * @param mixed $product
     *
     * @return mixed
     */
    public function purchase(array $details, $product)
    {
        try {
            $this->paymentGateway->charge(
                $product->fullPrice(),
                $details['payment_token']
            );
        } catch (Throwable $e) {
            $this->saveCharge($details, $product->id, true);

            return false;
        }

        unset($details['payment_token']);

        $order = $product->placeOrder($details);

        $this->saveCharge($order->toArray());

        return $order;
    }

    /**
     * Save charge details to database.
     *
     * @param array $details
     * @param int   $product
     * @param bool  $failed
     *
     * @return void
     */
    public function saveCharge(array $details, ?int $product = null, $failed = false): void
    {
        Charge::create([
            'details' => json_encode($details),
            'product_id' => $product,
            'status' => $failed ? 'failed' : 'successful',
        ]);
    }
}
