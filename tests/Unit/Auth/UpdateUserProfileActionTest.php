<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Auth\Actions\UpdateUserProfile;
use App\Contracts\Auth\UpdatesUserProfile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class UpdateUserProfileActionTest extends TestCase
{
    /** @test */
    public function it_addheres_to_common_interface()
    {
        $updator = new UpdateUserProfile();

        $this->assertInstanceOf(UpdatesUserProfile::class, $updator);
    }

    /** @test */
    public function it_can_update_given_users_profile()
    {
        $user = create(User::class);
        $userName = $user->name;
        $updator = new UpdateUserProfile();

        $updator->update($user, [
            'name' => 'Ninja Warrior',
            'email' => $user->email,
        ]);

        $this->assertNotEquals($userName, $user->fresh()->name);
    }

    /** @test */
    public function it_verifies_user_email_if_user_account_is_set_to_be_verified()
    {
        Notification::fake();

        Notification::assertNothingSent();

        $user = MustVerifyEmailUser::create([
            'username' => 'cindy.glover',
            'name' => 'Nels Cormier',
            'email' => 'bins.gerry@example.org',
            'phone' => '+13147338102',
            'password' => Hash::make('secret-password'),
        ]);
        $updator = new UpdateUserProfile();
        $updator->update($user, [
            'name' => 'Ninja Warrior',
            'email' => 'updated@email.com',
        ]);

        Notification::assertSentTo(
            [$user],
            VerifyEmail::class
        );
    }
}

class MustVerifyEmailUser extends User implements MustVerifyEmail
{
    protected $table = 'users';
}
