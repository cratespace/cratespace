<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Charge;
use App\Support\Money;

class ChargeTest extends TestCase
{
    public function testChargeConformsToPaymentContract()
    {
        $business = User::factory()->withBusiness()->create();
        $customer = User::factory()->asCustomer()->create();
        $charge = Charge::create([
            'user_id' => $business->id,
            'customer_id' => $customer->id,
            'details' => [
                'amount' => 1000,
                'payment_method' => 'pm_card_visa',
                'confirmation_method' => 'automatic',
                'confirm' => true,
                'currency' => Money::preferredCurrency(),
            ],
        ]);

        $this->assertEquals(1000, $charge->rawAmount());
        $this->assertEquals(Money::format(1000), $charge->amount());
        $this->assertEquals(1000, $charge->details('amount'));
    }
}
