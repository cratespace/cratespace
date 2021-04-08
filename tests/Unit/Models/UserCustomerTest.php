<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateAsCustomer()
    {
        $user = create(User::class);

        $user->createAsCustomer();

        $user = $user->fresh();

        $this->assertNotNull($user->profile->stripe_id);
        $this->assertEquals($user->profile->stripe_id, $user->customerId());

        $user->asStripeCustomer()->delete();
    }
}
