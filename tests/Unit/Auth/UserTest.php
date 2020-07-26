<?php

namespace Tests\Unit\Auth;

use App\Auth\User;
use Tests\TestCase;
use ReflectionClass;
use InvalidArgumentException;
use App\Models\User as UserModel;
use App\Contracts\Auth\Responsibility;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserTest extends TestCase
{
    /** @test */
    public function it_extends_the_base_user_model()
    {
        $user = new User();

        $this->assertInstanceOf(UserModel::class, $user);
    }

    /** @test */
    public function it_has_responsibilities()
    {
        $this->app['config']->set(
            'auth.responsibilities',
            [MockResponsibility::class]
        );

        $user = new User();

        $this->assertTrue(is_array($user->getResponsibilities()));
        foreach ($user->getResponsibilities() as $responsibility) {
            $this->assertInstanceOf(Responsibility::class, new $responsibility());
        }
    }

    /** @test */
    public function it_throws_exception_when_invalid_responsibility_is_set()
    {
        $this->expectException(HttpException::class);

        $this->app['config']->set(
            'auth.responsibilities',
            [InvalidResponsibility::class]
        );

        $user = new User();

        $user->new([
            'name' => 'John Vox Doe',
            'email' => 'john.vodo@sunnyside.com',
            'password' => 'CattleFarmer97',
            'password_confirmation' => 'CattleFarmer97',
            'business' => 'Sunny Side Exporters',
            'phone' => '91-0292-my-bum',
        ]);
    }

    /** @test */
    public function it_throws_exception_when_invalid_responsibility_is_set_to_be_resolved()
    {
        $this->expectException(InvalidArgumentException::class);

        $user = new User();

        $reflection = new ReflectionClass($user);
        $method = $reflection->getMethod('resolveResponsibility');
        $method->setAccessible(true);

        $method->invokeArgs($user, [InvalidResponsibility::class]);
    }

    /** @test */
    public function it_can_create_a_new_user_from_the_given_details()
    {
        $userCreator = new User();
        $user = $userCreator->new([
            'name' => 'John Vox Doe',
            'email' => 'john.vodo@sunnyside.com',
            'password' => 'CattleFarmer97',
            'password_confirmation' => 'CattleFarmer97',
            'business' => 'Sunny Side Exporters',
            'phone' => '91-0292-my-bum',
        ]);

        $this->assertInstanceOf(UserModel::class, $user);
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
     * Handle responsibility.
     *
     * @param \App\Models\User $user
     * @param array            $data
     *
     * @return App\Models\User
     */
    public function handle(UserModel $user, array $data): UserModel
    {
    }
}

class InvalidResponsibility
{
}
