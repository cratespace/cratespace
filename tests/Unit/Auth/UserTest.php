<?php

namespace Tests\Unit\Auth;

use Closure;
use Tests\TestCase;
use App\Models\User;
use App\Auth\Actions\CreateNewUser;
use App\Contracts\Support\Responsibility;

class UserTest extends TestCase
{
    /** @test */
    public function it_can_create_a_new_user_from_the_given_details()
    {
        $userCreator = new CreateNewUser();
        $user = $userCreator->create([
            'name' => 'John Vox Doe',
            'email' => 'john.vodo@sunnyside.com',
            'password' => 'CattleFarmer97',
            'password_confirmation' => 'CattleFarmer97',
            'business' => 'Sunny Side Exporters',
            'phone' => '91-0292-my-bum',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', [
            'name' => 'John Vox Doe',
            'email' => 'john.vodo@sunnyside.com',
            'phone' => '91-0292-my-bum',
        ]);
    }
}

class MockResponsibility implements Responsibility
{
    /**
     * Handle given data and pass it on to next action.
     *
     * @param array    $data
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(array $data, Closure $next)
    {
        return $next($data);
    }
}

class InvalidResponsibility
{
}
