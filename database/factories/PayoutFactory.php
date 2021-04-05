<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Payout;
use App\Support\Money;
use App\Services\Stripe\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payout::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $payment = Payment::create([
            'amount' => 1000,
            'currency' => Money::preferredCurrency(),
            'payment_method' => 'pm_card_visa',
        ]);

        $service = config('billing.service', 0.03);
        $amount = $payment->amount;
        $amount = $amount - ($amount * $service);

        return [
            'payment' => $payment->id,
            'amount' => $amount,
            'service_percentage' => $service,
            'user_id' => User::factory()->asBusiness()->create()->id,
            'paid_at' => null,
        ];
    }
}
