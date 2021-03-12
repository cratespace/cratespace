<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function testDeterminePermission()
    {
        $permission = Permission::create(['label' => '*']);
        $role = Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'An administrator can perform all actions',
        ]);

        $role->allowTo($permission);

        $this->assertTrue($role->can($permission));
    }
}
