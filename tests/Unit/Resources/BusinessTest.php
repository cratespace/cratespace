<?php

namespace Tests\Unit\Resources;

use PDOException;
use Tests\TestCase;
use App\Models\Business;

class BusinessTest extends TestCase
{
    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = $this->signIn();

        $this->assertInstanceOf(Business::class, $user->business);
    }

    /** @test */
    public function it_requires_a_unique_business_name()
    {
        $this->expectException(PDOException::class);

        $business = create(Business::class);

        $name = $business->name;

        Business::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(7),
            'street' => '22 Auburn Side',
            'city' => 'Sri Lanka',
            'state' => 'Western',
            'country' => 'Sri Lanka',
            'postcode' => 13500,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'user_id' => null,
        ]);
    }
}
