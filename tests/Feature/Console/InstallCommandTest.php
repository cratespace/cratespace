<?php

namespace Tests\Feature\Console;

use Tests\TestCase;
use Illuminate\Support\Facades\File;

class InstallCommandTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        File::move('.env', '.env.backup');

        config(['app.key' => '']);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        File::move('.env.backup', '.env');
    }

    /** @test */
    public function it_installs_the_application()
    {
        $this->artisan('cs:install')
            ->expectsQuestion('Database name', ':memory:')
            ->expectsQuestion('Database port', 3306)
            ->expectsQuestion('Database user', 'root')
            ->expectsQuestion('Database password (leave blank for no password)', '')
            ->expectsQuestion('Do you want to migrate the database?', 'no')
            ->expectsQuestion('Do you want to seed the database with default user and dummy data?', 'no')
            ->assertExitCode(0);
    }
}
