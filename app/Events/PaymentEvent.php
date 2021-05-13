<?php

namespace App\Events;

use App\Models\User;
use App\Facades\Stripe;
use App\Models\Business;
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

    /**
     * Get the payment made.
     *
     * @return \App\Contracts\Billing\Payment|null
     */
    public function payment(): ?Payment
    {
        return $this->payment;
    }

    /**
     * Get the merchant the product belongs to.
     *
     * @return \App\Models\User
     */
    public function business(): User
    {
        $business = Business::findUsingRegistrationNumber(
            $this->payment->metadata['merchant_registration_number']
        );

        return $business->user;
    }
}
