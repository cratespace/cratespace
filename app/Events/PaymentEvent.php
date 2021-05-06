<?php

namespace App\Events;

use App\Facades\Stripe;
use App\Contracts\Billing\Payment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

abstract class PaymentEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The payment instance.
     *
     * @var \App\Contracts\Billing\Payment
     */
    protected $payment;

    /**
     * Create a new event instance.
     *
     * @param \App\Contracts\Billing\Payment|null $payment
     * @param string|null                         $context
     *
     * @return void
     */
    public function __construct(?Payment $payment = null, ?string $context = null)
    {
        $this->payment = $payment;

        if (! is_null($context)) {
            Stripe::logger()->error($context);
        }
    }
}
