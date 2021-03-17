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
        return [
            'payment_intent' => 'pi_1DnXbp2eZvKYlo2Czed9qnYW',
            'user_id' => User::factory()->withBusiness()->create(),
            'amount' => 1000,
            'service_percentage' => config('billing.service'),
            'paid_at' => null,
        ];
    }
}
