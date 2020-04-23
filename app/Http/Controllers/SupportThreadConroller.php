<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Channel;
use App\Filters\ThreadFilter;
use App\Http\Requests\Thread as ThreadForm;
<<<<<<< HEAD
use App\Http\Controllers\Concerns\RetrivesResource;

class SupportThreadConroller extends Controller
{
    use RetrivesResource;

=======

class SupportThreadConroller extends Controller
{
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilter $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('support.threads.index', [
            'threads' => $threads,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('support.threads.create', [
            'channels' => Channel::all(),
            'threads' => Thread::query()
                ->orderBy('replies_count', 'desc')
                ->take(5)
                ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadForm $request)
    {
        $thread = user()->threads()->create($request->validated());

        if (request()->wantsJson()) {
            return response($thread, 201);
        }

        return $this->success($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Thread $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $channel, Thread $thread)
    {
        if (auth()->check()) {
            user()->read($thread);
        }

        $thread->increment('visits');

        return view('support.threads.show', compact('thread'));
    }

    /**
<<<<<<< HEAD
=======
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Thread $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
    }

    /**
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Thread       $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ThreadForm $request, string $channel, Thread $thread)
    {
        $thread->update($request->validated());

        return $this->success($thread->fresh()->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Thread $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $channel, Thread $thread)
    {
        $this->authorize('delete', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return $this->success(
            route('support.threads.index'),
            'Thread was deleted from the database.'
        );
    }
<<<<<<< HEAD
=======

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
>>>>>>> 5c9c75c6692cf9ba03e6ecf90986246ccdc6d951
}
