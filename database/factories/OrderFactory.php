<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Space;
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

        return [
            'code' => null,
            'confirmation_number' => null,
            'amount' => $space->price,
            'note' => $this->faker->paragraph(),
            'user_id' => $space->user_id,
            'customer_id' => create(User::class, [], 'asCustomer')->id,
            'payment' => null,
            'orderable_id' => $space->id,
            'orderable_type' => get_class($space),
        ];
    }
}
