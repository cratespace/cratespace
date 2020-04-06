<div class="bg-gray-100 p-8 text-sm">
    <div class="mb-4">
        <a class="btn btn-primary rounded py-2 px-3" href="{{ route('support.threads.create') }}">Start discussion</a>

        <div class="mt-2 text-gray-600">Friendly support from our community</div>

        <hr class="mt-4">
    </div>

    <div class="mb-4">
        <a href="#">Contact support</a>

        <div class="text-gray-600">24x7 help from our support staff</div>

        <hr class="mt-4">
    </div>

    <div class="mb-4">
        <ul>
            @forelse (App\Models\Channel::all() as $channel)
                <li class="mb-2">
                    <a href="{{ url('/support/threads/' . $channel->slug) }}">{{ $channel->name }}</a>
                </li>
            @empty
                <li>No channels found.</li>
            @endforelse
        </ul>
    </div>

    <div>
        <hr class="mb-4">

        <a href="#">Feedback about this page?</a>
    </div>
</div>
