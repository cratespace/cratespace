<div class="mb-6 flex items-start">
    <div class="flex-no-shrink h-8 w-8">
        <a class="bg-blue-200 shadow-none px-0 h-8 w-8 flex items-center justify-center rounded-full overflow-hidden dropdown-toggle" href="#">
            <img class="h-8 w-8" src="{{ $reply->agent->image ?? asset('img/default.jpg') }}">
        </a>
    </div>

    <div class="ml-6 text-gray-700">
        <div class="mt-1 leading-none">
            <h6 class="font-semibold text-gray-800">{{ $reply->agent->name }}</h6>
        </div>

        <div class="mt-4 text-sm leading-relaxed">
            {{ $reply->body }}
        </div>

        <div class="mt-4 flex items-center">
            <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>

            @can('update', $reply)
                <a class="ml-4 text-xs text-gray-500" href="#" role="button" data-toggle="modal" data-target="#replyModal">Edit</a>

                <a class="ml-4 text-xs text-gray-500" href="{{ route('replies.destroy', ['ticket' => $ticket, 'reply' => $reply]) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $reply->id }}').submit();">
                    Delete
                </a>

                <form id="delete-form-{{ $reply->id }}" action="{{ route('replies.destroy', ['ticket' => $ticket, 'reply' => $reply]) }}" method="POST" style="display: none;">
                    @csrf

                    @method('DELETE')
                </form>
            @endcan

            @auth
                <a class="ml-4 text-xs text-gray-500" href="/">3 Likes</a>

                <a class="ml-4 text-xs text-gray-500" href="/">Reply</a>
            @endauth
        </div>
    </div>
</div>

<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog rounded-lg overflow-hidden">
        <form class="modal-content" action="{{ route('replies.update', ['thread' => $thread, 'reply' => $reply]) }}" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Reply to <span class="font-semibold text-blue-500">conversation</span></h5>

                <button type="button" class="close font-normal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                @csrf

                @method('PUT')

                <textarea id="body" name="body" class="form-textarea block w-full" rows="10" placeholder="Type here to reply to thread">{{ $reply->body }}</textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                <button type="submit" class="ml-4 btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
