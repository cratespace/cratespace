<?php

namespace App\Billing\PaymentGateways;

use App\Models\Order;
use App\Billing\Charges\Charge;

abstract class PaymentGateway
{
    protected function createCharge(Order $order, string $paymentToken, ?array $details = null)
    {
        $chargeDetails = new Charge([
            'amount' => $order->total,
            'card_last_four' => substr($this->tokens[$paymentToken], -4),
            'response' => (array) $details ?? 'local',
        ]);

        $order->charge()->create([
            'confirmation_number' => $order->confirmation_number,
            'details' => (array) $chargeDetails->getData(),
        ]);

        return $chargeDetails->getData();
    }
}
