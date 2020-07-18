<?php

namespace Tests\Unit\Validations;

use Tests\TestCase;
use App\Validations\OrderValidation;

class OrderValidationTest extends TestCase
{
    /** @test */
    public function it_can_dynamically_get_the_name_of_the_resource_currently_being_accessed()
    {
        $rules = [
            'email' => ['required', 'string', 'email', 'max:255'],
            'payment_token' => ['required', 'string'],
        ];

        $this->app['config']->set('validation.order', $rules);

        $orderValidator = new OrderValidation($this->app['config']);

        $this->assertSame($orderValidator->rules(), $rules);
    }
}
