<?php

namespace Tests\Concerns;

use Illuminate\Foundation\Testing\RefreshDatabase;

trait InteractsWithUserRoles
{
    use RefreshDatabase;

    public function createRolesAndPermissions()
    {
        $this->artisan('db:seed', ['class' => 'DefaultAuthorizationsSeeder']);
    }
}
