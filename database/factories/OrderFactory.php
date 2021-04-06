<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Space;
use App\Support\Money;
use App\Services\Stripe\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $space = create(Space::class);

        // $payment = Payment::create([
        //     'amount' => 1000,
        //     'currency' => Money::preferredCurrency(),
        //     'payment_method' => 'pm_card_visa',
        // ]);

        return [
            'confirmation_number' => null,
            'amount' => $space->fullAmount(),
            'note' => $this->faker->paragraph(),
            'user_id' => $space->user_id,
            'customer_id' => User::factory()->asCustomer()->create()->id,
            'payment' => 'pi_1Icsx8Hzt2k6m3ozwEKphb27',
            'orderable_id' => $space->id,
            'orderable_type' => get_class($space),
        ];
    }
}
