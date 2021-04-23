<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BusinessInvitation extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * The business invitation instance.
     *
     * @var \App\Models\Invitation
     */
    protected $invitation;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Invitation $invitation
     *
     * @return void
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.businesses.invitations.new-invitation',
            [
                'acceptUrl' => URL::signedRoute('invitations.accept', [
                    'invitation' => $this->invitation,
                ]),
            ]
        )->subject(__('Cratespace Invitation'));
    }
}
