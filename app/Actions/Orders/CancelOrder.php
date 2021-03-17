<?php

namespace App\Actions\Orders;

use App\Events\OrderCanceled;
use App\Events\PaymentRefunded;
use App\Contracts\Billing\Client;
use App\Contracts\Billing\Payment;
use App\Contracts\Purchases\Order;
use Illuminate\Support\Facades\DB;
use App\Contracts\Purchases\Product;
use App\Exceptions\OrderCancellationException;

class CancelOrder
{
    /**
     * Cancel resource action.
     *
     * @param \App\Contracts\Purchases\Order $order
     *
     * @return void
     */
    public function cancel(Order $order): void
    {
        if (! $order->eligibleForCancellation()) {
            throw OrderCancellationException::notEligible($order);
        }

        $this->releaseProduct($order->product());

        $this->provideRefund($order);

        $this->cancelPayout($order->details);

        OrderCanceled::dispatch(clone $order);

        $order->delete();
    }

    /**
     * Release product from order and make available again.
     *
     * @param \App\Contracts\Purchases\Product $product
     *
     * @return void
     */
    protected function releaseProduct(Product $product): void
    {
        DB::transaction(fn () => $product->release());
    }

    /**
     * Provide refund to customer.
     *
     * @param \App\Contracts\Purchases\Order $order
     *
     * @return void
     */
    protected function provideRefund(Order $order): void
    {
        $refund = app(Client::class)->createRefund([
            'amount' => $order->rawAmount(),
            'payment_intent' => $order->details->id,
            'reason' => 'Cratespace purchase cancellation.',
        ]);

        PaymentRefunded::dispatch($refund);
    }

    /**
     * Cancel payout attributed to business.
     *
     * @param \App\Contracts\Purchases\Order $payment
     *
     * @return void
     */
    protected function cancelPayout(Payment $payment): void
    {
        app(CancelPayout::class)->cancel($payment);
    }
}
