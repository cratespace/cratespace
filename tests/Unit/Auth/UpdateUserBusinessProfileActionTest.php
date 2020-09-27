<?php

namespace Tests\Unit\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use App\Contracts\Auth\UpdatesUserProfile;
use App\Auth\Actions\UpdateBusinessProfile;

class UpdateUserBusinessProfileActionTest extends TestCase
{
    /** @test */
    public function it_addheres_to_common_interface()
    {
        $updator = new UpdateBusinessProfile();

        $this->assertInstanceOf(UpdatesUserProfile::class, $updator);
    }

    /** @test */
    public function it_can_update_given_users_profile()
    {
        $user = create(User::class);
        $business = create(Business::class, ['user_id' => $user->id]);
        $businessName = $business->name;
        $updator = new UpdateBusinessProfile();

        $updator->update($user, [
            'name' => 'Chocolate Factory',
        ]);

        $this->assertNotEquals($businessName, $business->fresh()->name);
    }
}
