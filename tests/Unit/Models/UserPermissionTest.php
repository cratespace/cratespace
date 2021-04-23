<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPermissionTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanBeAssignedRoles()
    {
        $role = Role::create(['name' => 'Administrator', 'slug' => 'admin']);
        $user = User::create([
            'name' => 'Thavarshan Thayananthajothy',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'phone' => '0712345678',
            'password' => Hash::make('WhatsThatBehinfYourEar?'),
        ]);

        $user->assignRole($role);

        $this->assertTrue($user->hasRole('Administrator'));
    }

    public function testRolesCanBeAssignedPermissions()
    {
        $role = Role::create(['name' => 'Administrator', 'slug' => 'admin']);
        $permissions = ['purchase', 'create', 'view', 'delete'];

        foreach ($permissions as $permission) {
            Permission::create(['label' => $permission]);
        }

        $role->allowTo('purchase');

        $this->assertTrue($role->can('purchase'));
    }

    public function testUserCanBeAllowedPermissions()
    {
        $role = Role::create(['name' => 'Administrator', 'slug' => 'admin']);
        $permissions = ['purchase', 'create', 'view', 'delete'];
        $user = User::create([
            'name' => 'Thavarshan Thayananthajothy',
            'username' => 'Thavarshan',
            'email' => 'tjthavarshan@gmail.com',
            'phone' => '0712345678',
            'password' => Hash::make('WhatsThatBehinfYourEar?'),
        ]);

        foreach ($permissions as $permission) {
            Permission::create(['label' => $permission]);
        }

        $role->allowTo('purchase');
        $user->assignRole($role);

        $this->assertTrue($user->findRole('Administrator')->can('purchase'));
    }
}
