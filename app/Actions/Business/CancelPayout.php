<?php

namespace App\Actions\Business;

use App\Models\Payout;
use App\Contracts\Billing\Payment;

class CancelPayout
{
    /**
     * Cancel business payout.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return void
     *
     * @throws \App\Exceptions\InvalidActionException
     */
    public function cancel(Payment $payment): void
    {
        $payout = Payout::findUsingPayment($payment->id);

        if (is_null($payout)) {
            return;
        }

        $payout->cancel();
    }
}
