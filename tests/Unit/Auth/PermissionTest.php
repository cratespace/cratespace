<?php

namespace Tests\Unit\Auth;

use App\Auth\Api\Permission;
use PHPUnit\Framework\TestCase;

class PermissionTest extends TestCase
{
    /** @test */
    public function permissions_can_be_registered()
    {
        $permissions = [
            'create',
            'read',
            'update',
            'delete',
        ];

        Permission::permissions($permissions);

        $this->assertEquals($permissions, Permission::$permissions);
    }

    /** @test */
    public function a_default_api_token_permission_can_be_registered()
    {
        $defaultPermissions = ['read'];

        Permission::defaultApiTokenPermissions($defaultPermissions);

        $this->assertEquals($defaultPermissions, Permission::$defaultPermissions);
    }
}
