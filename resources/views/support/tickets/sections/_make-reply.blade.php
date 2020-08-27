<div class="mt-10">
    <div class="flex-1 ml-6 text-lg text-gray-700">
        <form class="w-full" action="{{ route('replies.store', ['ticket' => $ticket->code]) }}" method="POST">
            @csrf

            <input type="hidden" name="agent_id" value="{{ optional(user())->id ?: null }}">

            <div>
                <textarea id="body" name="body" class="form-textarea block w-full" rows="3" placeholder="Type here to reply to thread"></textarea>
            </div>

            <div class="mt-6">
                <button class="btn btn-primary leading-8">Post reply</button>
            </div>
        </form>
    </div>
</div>
