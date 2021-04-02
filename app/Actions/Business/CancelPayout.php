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
     */
    public function cancel(Payment $payment): void
    {
        $payout = $this->getPayout($payment->id);

        $payout->delete();
    }

    /**
     * Get payout details.
     *
     * @param string $id
     *
     * @return \App\Models\Payout
     */
    protected function getPayout(string $id): Payout
    {
        return Payout::wherePayment($id)->firstOrFail();
    }
}
