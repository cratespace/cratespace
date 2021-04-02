<?php

namespace App\Http\Controllers\Business;

use App\Models\User;
use App\Models\Invitation;
use App\Jobs\InviteBusiness;
use App\Http\Controllers\Controller;
use App\Http\Responses\BusinessResponse;
use App\Http\Requests\InviteBusinessRequest;

class InviteBusinessController extends Controller
{
    /**
     * Invite a business in to Cratespace.
     *
     * @param \App\Http\Requests\InviteBusinessRequest $request
     * @param \App\Models\User                         $user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InviteBusinessRequest $request, User $user)
    {
        InviteBusiness::dispatch($user);

        return BusinessResponse::dispatch($request);
    }

    /**
     * Accept a business invitation.
     *
     * @param \Laravel\Jetstream\TeamInvitation $invitation
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Invitation $invitation)
    {
        $invitation->accept();

        return redirect('/register')->banner(
            __('Great! You have accepted the invitation to join Cratespace.'),
        );
    }
}
