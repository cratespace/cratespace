<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Events\BusinessInvited;
use App\Exceptions\UserAlreadyOnboard;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Actions\Business\InviteBusiness as InviteBusinessAction;

class InviteBusiness implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The invite business action class instance.
     *
     * @var \App\Actions\Business\InviteBusiness
     */
    protected $action;

    /**
     * Create a new job instance.
     *
     * @param \App\Actions\Business\InviteBusiness $action
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(InviteBusinessAction $action)
    {
        try {
            $invitation = $action->invite($this->user);

            BusinessInvited::dispatch($invitation);
        } catch (UserAlreadyOnboard $e) {
            $this->fail($e);
        }
    }
}
