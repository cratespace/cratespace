<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Payout;
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
        $user = User::factory()->withBusiness()->create();

        return [
            'payment_intent' => 'pi_1DnXbp2eZvKYlo2Czed9qnYW',
            'business_id' => $user->business->id,
            'amount' => 1000,
            'service_percentage' => config('billing.service'),
            'paid_at' => null,
        ];
    }
}
