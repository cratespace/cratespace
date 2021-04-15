<?php

namespace App\Observers;

use App\Models\Invitation;

class InvitationObserver
{
    /**
     * Handle the Invitation "created" event.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return void
     */
    public function created(Invitation $invitation)
    {
        //
    }

    /**
     * Handle the Invitation "updated" event.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return void
     */
    public function updated(Invitation $invitation)
    {
        //
    }

    /**
     * Handle the Invitation "deleted" event.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return void
     */
    public function deleted(Invitation $invitation)
    {
        //
    }

    /**
     * Handle the Invitation "restored" event.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return void
     */
    public function restored(Invitation $invitation)
    {
        //
    }

    /**
     * Handle the Invitation "force deleted" event.
     *
     * @param  \App\Models\Invitation  $invitation
     * @return void
     */
    public function forceDeleted(Invitation $invitation)
    {
        //
    }
}
