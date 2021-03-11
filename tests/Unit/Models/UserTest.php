<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testHasABusinessProfile()
    {
        $user = User::factory()->withBusiness()->create();

        $this->assertInstanceOf(Business::class, $user->business);
    }

    public function testUserModelAppendsSessionData()
    {
        $user = create(User::class);

        $this->assertArrayHasKey('sessions', $user->toArray());
    }

    public function testRoleAssignment()
    {
        $user = create(User::class);
        $role = Role::create(['name' => 'Customer', 'slug' => 'customer']);

        $user->assignRole($role);

        $this->assertTrue($user->hasRole($role));
    }
}
