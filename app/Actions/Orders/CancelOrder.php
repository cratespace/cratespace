<?php

namespace App\Actions\Orders;

use App\Contracts\Orders\Order;
use App\Events\PaymentRefunded;
use App\Services\Stripe\Refund;
use App\Contracts\Billing\Payment;
use Illuminate\Support\Facades\DB;
use App\Actions\Business\CancelPayout;

class CancelOrder
{
    /**
     * Cancel the given order.
     *
     * @param \App\Contracts\Orders\Order $order
     *
     * @return void
     */
    public function cancel(Order $order): void
    {
        $this->provideRefund($order);

        $this->cancelPayout($order->payment);

        $order->cancel();
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
        $refund = Refund::create([
            'amount' => $order->rawAmount(),
            'payment_intent' => $order->payment->id,
            'reason' => 'requested_by_customer',
        ]);

        PaymentRefunded::dispatch($refund);
    }

    /**
     * Cancel payout attributed to business.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return void
     */
    protected function cancelPayout(Payment $payment): void
    {
        DB::transaction(function () use ($payment) {
            app(CancelPayout::class)->cancel($payment);
        });
    }
}
