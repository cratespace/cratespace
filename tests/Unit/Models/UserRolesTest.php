<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRolesTest extends TestCase
{
    use RefreshDatabase;

    public function testDynamicallyCheckRole()
    {
        $business = User::factory()->asBusiness()->create();
        $customer = User::factory()->asCustomer()->create();

        $this->assertTrue($customer->isCustomer());
        $this->assertFalse($customer->isBusiness());
        $this->assertTrue($business->isBusiness());
        $this->assertFalse($business->isCustomer());
    }
}
