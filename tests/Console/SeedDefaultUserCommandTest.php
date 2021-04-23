<?php

namespace Tests\Console;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SeedDefaultUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testSeedDefaultUser()
    {
        config()->set('auth.providers.users.model', User::class);
        config()->set('defaults.users.credentials', [
            'name' => 'James Silverman',
            'username' => 'JKAMonster',
            'phone' => '0712345678',
            'email' => 'silver.james@gmail.com',
            'password' => Hash::make('cthuluEmployee'),
        ]);

        $this->artisan('cs:user')
            ->expectsConfirmation('Do you want to create a default user from preset data?', 'yes')
            ->assertExitCode(0);

        $this->assertTrue(User::whereName('James Silverman')->exists());
    }

    public function testSeedCustomUserDetails()
    {
        $this->withoutExceptionHandling();

        $this->artisan('cs:user')
            ->expectsConfirmation('Do you want to create a default user from preset data?', 'no')
            ->expectsQuestion('Full name', 'James Silverman')
            ->expectsQuestion('Username', 'JamesSilverman')
            ->expectsQuestion('Email address', 'silver.james@monster.com')
            ->expectsQuestion('Phone number', '0712345678')
            ->expectsQuestion('Password', 'cthuluEmployee')
            ->assertExitCode(0);

        $this->assertTrue(User::whereName('James Silverman')->exists());
    }
}
