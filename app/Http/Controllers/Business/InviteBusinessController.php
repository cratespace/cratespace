<?php

namespace App\Http\Controllers\Business;

use App\Models\Invitation;
use App\Jobs\InviteBusiness;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\InviteBusinessRequest;
use App\Http\Responses\Business\InviteBusinessResponse;
use App\Http\Responses\Business\InvitationAcceptedResponse;

class InviteBusinessController extends Controller
{
    /**
     * Invite a business in to Cratespace.
     *
     * @param \App\Http\Requests\Business\InviteBusinessRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InviteBusinessRequest $request)
    {
        $user = $request->tap(fn ($user) => InviteBusiness::dispatch($user));

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
