<?php

namespace Tests\Feature\Seeders;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DefaultUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function testDefaultUserCanBeSeeded()
    {
        $this->artisan('db:seed', ['class' => 'DefaultUserSeeder'])->assertExitCode(0);
    }
}
