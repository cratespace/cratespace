<?php

namespace Tests\Concerns;

use Illuminate\Foundation\Testing\RefreshDatabase;

trait CreatesUserRoles
{
    use RefreshDatabase;

    public function createRolesAndPermissions()
    {
        $this->artisan('db:seed', ['class' => 'DefaultAuthorizationsSeeder']);
    }
}
