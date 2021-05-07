<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => 'native-' . Str::random(24),
            'pm_type' => 'card',
            'pm_last_four' => 1234,
            'user_id' => create(User::class)->id,
        ];
    }
}
