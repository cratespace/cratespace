<?php

namespace Tests\Unit\Models;

use Throwable;
use Tests\TestCase;
use App\Models\User;
use InvalidArgumentException;
use App\Models\Values\Address;
use App\Models\Values\Settings;
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
                'line1' => '59 Martin Road',
                'city' => 'Jaffna',
                'state' => 'Northern Province',
                'country' => 'Sri Lanka',
                'postal_code' => 40000,
            ],
        ]);

        $this->assertInstanceOf(Address::class, $user->address);
        $this->assertEquals('59 Martin Road', $user->address->line1);
        $this->assertEquals('Jaffna', $user->address->city);
        $this->assertEquals('Northern Province', $user->address->state);
        $this->assertEquals('Sri Lanka', $user->address->country);
        $this->assertEquals(40000, $user->address->postal_code);
    }

    public function testAddressValueThrowsExceptionForInvalidProperty()
    {
        $user = create(User::class, [
            'address' => [
                'street' => '59 Martin Road',
            ],
        ]);

        try {
            $user->address->business;
        } catch (Throwable $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
        }
    }

    public function testCastSettingsValueAsSettingsValueObject()
    {
        $user = create(User::class, [
            'settings' => [
                'notifications' => ['web', 'email', 'sms'],
            ],
        ]);

        $this->assertInstanceOf(Settings::class, $user->settings);
        $this->assertEquals(['web', 'email', 'sms'], $user->settings->notifications);
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
