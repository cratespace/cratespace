<div>
    @forelse ($ticket->replies as $reply)
        @include('support.sections._reply', ['reply' => $reply])
    @empty
        <div>
            <div class="overflow-hidden rounded-lg border-2 border-dotted">
                <div class="px-4 py-5 sm:px-6 text-center">
                    <div class="text-sm">Thread has no replies yet.</div>
                </div>
            </div>
        </div>
    @endforelse
</div>
