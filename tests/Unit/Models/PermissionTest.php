<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Permission;

class PermissionTest extends TestCase
{
    public function testDetermineApplicationHasPermissions()
    {
        Permission::create(['label' => 'purchase']);

        $this->assertTrue(Permission::hasPermissions());
    }

    public function testGetValidPermissions()
    {
        $permissions = ['purchase', 'manage', 'delete', 'cancel'];

        foreach ($permissions as $permission) {
            Permission::create(['label' => $permission]);
        }

        $this->assertEquals($permissions, Permission::validPermissions([
            'purchase', 'manage', 'delete', 'cancel', 'read', 'update', 'remove',
        ]));
    }
}
