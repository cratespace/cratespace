<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Values\Address;
use Cratespace\Preflight\Models\Role;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testInstantiation()
    {
        $user = new User();

        $this->assertInstanceOf(Authenticatable::class, $user);
    }

    public function testCastAddressValueAsAddressValueObject()
    {
        $user = create(User::class, [
            'address' => [
                'street' => '59 Martin Road',
                'city' => 'Jaffna',
                'state' => 'Northern Province',
                'country' => 'Sri Lanka',
                'postcode' => 40000,
            ],
        ]);

        $this->assertInstanceOf(Address::class, $user->address);
        $this->assertEquals('59 Martin Road', $user->address->street);
        $this->assertEquals('Jaffna', $user->address->city);
        $this->assertEquals('Northern Province', $user->address->state);
        $this->assertEquals('Sri Lanka', $user->address->country);
        $this->assertEquals(40000, $user->address->postcode);
    }

    public function testUserCanBeAssignedARole()
    {
        $role = Role::create(['name' => 'Administrator', 'slug' => 'admin']);
        $user = create(User::class);
        $user->assignRole($role);

        $this->assertTrue($user->hasRole('Administrator'));
        $this->assertFalse($user->hasRole('Customer'));
    }
}
