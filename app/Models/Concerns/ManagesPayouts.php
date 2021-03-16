<?php

namespace App\Models\Concerns;

use App\Contracts\Billing\Payment;
use App\Contracts\Actions\CalculatesAmount;

trait ManagesPayouts
{
    /**
     * Credit business with payment amount and save payout details.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return void
     */
    public function makePayout(Payment $payment): void
    {
        tap($this->payoutCalculator(), function ($payout) use ($payment) {
            $this->addCredit(
                $amount = $payout->calculate($payment->rawAmount())
            );

            $this->payouts()->create([
                'payment_intent' => $payment->id,
                'amount' => $amount,
                'service_percentage' => $payout->servicePercentage(),
            ]);
        });
    }

    /**
     * Get payout amount calculator.
     *
     * @return \App\Contracts\Actions\CalculatesAmount
     */
    protected function payoutCalculator(): CalculatesAmount
    {
        return app(CalculatesAmount::class);
    }
}
