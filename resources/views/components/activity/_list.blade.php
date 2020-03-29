@forelse ($activity as $date => $instance)
    <div class="my-4">
        <span class="relative inline-block px-3 py-1 font-semibold text-gray-800 leading-tight text-sm">
            <span aria-hidden="" class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
            <span class="relative">{{ $date}}</span>
        </span>
    </div>

    <div class="pl-5">
        @foreach ($instance as $record)
            <div class="pb-3 relative border-l-2 border-gray-200">
                <div class="rounded-full bg-gray-300 h-4 w-4 border-2 border-white mr-2 absolute top-0 left-0 -ml-2">
                    &nbsp;
                </div>

                <div class="ml-8">
                    @if (view()->exists("components.activity.types.{$record->type}"))
                        @include ("activities.components.{$record->type}", ['record' => $record])
                    @endif

                    <div class="mb-3">
                        <span class="text-xs text-gray-500">{{ $record->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@empty
    <p class="text-gray-500 my-10">There is no activity for this user yet.</p>
@endforelse
