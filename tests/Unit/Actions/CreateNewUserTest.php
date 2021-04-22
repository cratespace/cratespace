<?php

namespace Tests\Unit\Actions;

use Mockery as m;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use App\Actions\Auth\CreateNewUser;

class CreateNewUserTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testCreateUserAccountWithProfile()
    {
        $user = m::mock(User::class);
        $creator = m::mock(CreateNewUser::class);
        $creator->shouldAllowMockingProtectedMethods();
        $creator->shouldReceive('create')
            ->once()
            ->with([])
            ->andReturn($user);

        $this->assertInstanceOf(User::class, $creator->create([]));
    }

    public function testDetermineUserType()
    {
        $creator = m::mock(CreateNewUser::class);
        $creator->shouldAllowMockingProtectedMethods();
        $creator->shouldReceive('isForBusiness')
            ->once()
            ->with($data = ['type' => 'business'])
            ->andReturn(true);

        $this->assertTrue($creator->isForBusiness($data));
    }

    public function testCreateUserAccount()
    {
        $user = m::mock(User::class);
        $creator = m::mock(CreateNewUser::class);
        $creator->shouldAllowMockingProtectedMethods();
        $creator->shouldReceive('createUser')
            ->once()
            ->with([])
            ->andReturn($user);

        $this->assertInstanceOf(User::class, $creator->createUser([]));
    }
}
