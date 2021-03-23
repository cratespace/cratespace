<?php

namespace App\Actions\Business;

use App\Models\User;
use App\Models\Invitation;
use App\Mail\BusinessInvitation;
use Illuminate\Support\Facades\Mail;

class InviteBusiness
{
    /**
     * Preform certain action using the given data.
     *
     * @param array[] $data
     *
     * @return \App\Models\Invitation
     */
    public function invite(User $user): Invitation
    {
        $invitation = $user->invite();

        Mail::to($user->email)->send(
            new BusinessInvitation($invitation)
        );

        return $invitation;
    }
}
