<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use App\Http\Requests\Reply as ReplyForm;

class ReplyController extends Controller
{
    /**
     * Fetch all relevant replies.
     *
     * @param string             $channel
     * @param \App\Models\Thread $thread
     */
    public function index(string $channel, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Persist a new reply.
     *
     * @param string             $channel
     * @param \App\Models\Thread $thread
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(string $channel, Thread $thread, ReplyForm $request)
    {
        if ($thread->locked) {
            return response('Thread is locked', 422);
        }

        return $thread->addReply([
            'body' => $request->body,
            'user_id' => user('id'),
        ])->load('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reply        $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ReplyForm $request, Reply $reply)
    {
        $reply->update($request->validated());

        return $this->success($reply->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reply $reply
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['message' => 'Reply deleted.']);
        }

        return back()->with(['message' => 'Your reply was deleted.']);
    }
}
