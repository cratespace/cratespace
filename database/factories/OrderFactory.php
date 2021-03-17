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
            'confirmation_number' => null,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'price' => $space->price,
            'tax' => $space->tax,
            'total' => $space->fullPrice(),
            'note' => $this->faker->paragraph(),
            'space_id' => $space->id,
            'user_id' => $space->user_id,
            'customer_id' => User::factory()->asCustomer()->create()->id,
            'details' => null,
        ];
    }
}
