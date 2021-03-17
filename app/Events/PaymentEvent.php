<?php

namespace App\Events;

use App\Models\Business;
use App\Contracts\Billing\Payment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class PaymentEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The instance of the payment.
     *
     * @var \App\Contracts\Billing\Payment
     */
    public $payment;

    /**
     * Create a new event instance.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the business the payment is for.
     *
     * @return \App\Models\Business
     */
    public function business(): Business
    {
        return Business::find($this->payment->metadata['businessId']);
    }
}
