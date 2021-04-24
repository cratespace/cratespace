<?php

namespace App\Jobs;

use Throwable;
use App\Models\User;
use App\Support\HasUser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Contracts\Actions\DeletesUsers;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeleteUserJob implements ShouldQueue
{
    use HasUser;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Instance of user requested to be deleted.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param \App\Models\User
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
     * @param \App\Contracts\Auth\DeletesUsers $deletor
     *
     * @return void
     */
    public function handle(DeletesUsers $deletor)
    {
        try {
            $deletor->delete($this->user);
        } catch (Throwable $e) {
            $this->fail($e);
        }
    }
}
