<?php

namespace App\Observers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyObserver
{
    /**
     * Handle the reply "creating" event.
     *
     * @param \App\Models\Reply $reply
     *
     * @return void
     */
    public function creating(Reply $reply)
    {
        if (is_null(request()->agent_id)) {
            $reply->customer_id = $reply->ticket->customer_id;
        }
    }
}
