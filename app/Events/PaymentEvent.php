<?php

namespace App\Events;

use App\Models\User;
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
    public function __construct(?Payment $payment = null)
    {
        $this->payment = $payment;
    }

    /**
     * Get the merchant the product belongs to.
     *
     * @return \App\Models\User|null
     */
    public function business(): ?User
    {
        return optional($this->payment->product())->merchant();
    }
}
