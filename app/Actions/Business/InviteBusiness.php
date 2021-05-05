<?php

namespace App\Actions\Business;

use App\Models\User;
use App\Models\Invitation;
use App\Events\BusinessInvited;
use App\Mail\BusinessInvitation;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\InvitationException;

class InviteBusiness
{
    /**
     * Preform certain action using the given data.
     *
     * @param array[] $data
     *
     * @return \App\Models\Invitation
     *
     * @throws \App\Exceptions\InvitationException
     */
    public function invite(User $user): Invitation
    {
        if ($user->isCustomer()) {
            throw new InvitationException('User is a customer');
        }

        $invitation = $user->invite();

        Mail::to($user->email)->send(
            new BusinessInvitation($invitation)
        );

        BusinessInvited::dispatch($invitation);

        return $invitation;
    }
}
