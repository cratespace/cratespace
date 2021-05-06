<?php

namespace App\Actions\Business;

use App\Models\User;
use App\Models\Payout;
use App\Contracts\Billing\Payment;

class MakeNewPayout
{
    /**
     * Make the payout for the business.
     *
     * @param \App\Models\User               $user
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return \App\Models\Payout
     */
    public function make(User $user, Payment $payment): Payout
    {
        return $user->makePayout([
            'payment' => $payment->id,
            'amount' => $this->calculatePayoutAmount($payment->rawAmount()),
            'service_percentage' => $this->getServicePercentage(),
        ]);
    }

    /**
     * Calculate the payout amount for the business.
     *
     * @param int $amount
     *
     * @return int
     */
    protected function calculatePayoutAmount(int $amount): int
    {
        return $amount - ($amount * $this->getServicePercentage());
    }

    /**
     * Get the service charge percentage.
     *
     * @return float
     */
    protected function getServicePercentage(): float
    {
        return config('billing.service');
    }
}
