<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => create(User::class),
            'type' => 'standard',
            'name' => $name = $this->faker->company,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'registration_number' => rand(10000, 100000),
            'business_type' => 'company',
            'mcc' => rand(10000, 100000),
        ];
    }
}
