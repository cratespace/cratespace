<?php

namespace App\Http\Controllers\Business;

use App\Models\User;
use App\Models\Invitation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Invitable;
use App\Http\Requests\Business\InviteBusinessRequest;
use App\Http\Responses\Business\InviteBusinessResponse;
use App\Http\Responses\Business\InvitationAcceptedResponse;

class InviteBusinessController extends Controller
{
    use Invitable;

    /**
     * Invite a business in to Cratespace.
     *
     * @param \App\Http\Requests\Business\InviteBusinessRequest $request
     * @param \App\Models\User                                  $user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InviteBusinessRequest $request, User $user)
    {
        $this->invite($request, $user);

        return InviteBusinessResponse::dispatch($user);
    }

    /**
     * Accept a business invitation.
     *
     * @param \App\Models\Invitation $invitation
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Invitation $invitation)
    {
        $invitation->accept();

        return InvitationAcceptedResponse::dispatch($invitation->user);
    }
}
