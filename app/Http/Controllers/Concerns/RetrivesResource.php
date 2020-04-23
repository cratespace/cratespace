<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Thread;
use App\Models\Channel;
use App\Filters\ThreadFilter;

trait RetrivesResource
{
    /**
     * Fetch all relevant threads.
     *
     * @param \App\Models\Channel        $channel
     * @param \App\Filters\ThreadFilters $filters
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getThreads(Channel $channel, ThreadFilter $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(10);
    }
}
