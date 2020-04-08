<div class="bg-white rounded-lg shadow hover:shadow-lg px-4 py-5 mb-8 sm:px-6 flex flex-col flex-1">
    <div class="flex justify-between">
        <div class="mb-4 mr-3">
            <div class="mb-4 flex items-center">
                <div class="mr-3">
                    <div class="h-16 w-16">
                        <img class="h-16 w-16 rounded-full" src="{{ $space->present()->business->photo }}" alt="{{ $space->present()->business->name }}" />
                    </div>
                </div>

                <div>
                    <div class="text-gray-800 text-sm leading-tight font-semibold">{{ $space->present()->business->name }}</div>

                    <div class="text-xs font-bold text-gray-600 uppercase mt-1">{{ '#' . $space->uid }}</div>

                    <div class="text-xs text-indigo-500">{{ $space->type }}</div>
                </div>
            </div>

            <div>
                <span class="text-xs text-gray-600">Dimensions</span>

                <div class="flex text-xl mb-2">
                    <div class="mr-3">
                        {{ $space->height }} <span class="text-sm text-gray-600">Ft</span>
                    </div>

                    <div class="mr-3">
                        {{ $space->width }} <span class="text-sm text-gray-600">Ft</span>
                    </div>

                    <div>
                        {{ $space->length }} <span class="text-sm text-gray-600">Ft</span>
                    </div>
                </div>
            </div>

            <div>
                <span class="text-xs text-gray-600">Maximum allowable weight</span>

                <div class="text-xl">
                    {{ $space->weight }} <span class="text-sm text-gray-600">Kg</span>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex justify-between items-end">
                <div>
                    <div class="text-sm mb-4">
                        <div>
                            <span class="text-xs text-gray-600">Departs</span>
                            <div class="font-medium">{{ $space->departs_at->format('M jS, g:i a') }}</div>
                        </div>

                        <div class="text-xs text-gray-600">
                            {{ $space->departs_at->diffForHumans() }}
                        </div>
                    </div>

                    <div class="text-sm">
                        <div>
                            <span class="text-xs text-gray-600">Arrives</span>
                            <div class="font-medium">{{ $space->arrives_at->format('M jS, g:i a') }}</div>
                        </div>

                        <div class="text-xs text-gray-600">
                            {{ $space->arrives_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-6 flex justify-between items-end">
        <div>
            <div class="mb-2">
                <div class="text-xs text-gray-600">Country based in</div>

                <div>{{ $space->base }}</div>
            </div>

            <div class="mb-2">
                <div class="text-xs text-gray-600">Origin</div>

                <div>{{ $space->origin }}</div>
            </div>

            <div>
                <div class="text-xs text-gray-600">Destination</div>

                <div>{{ $space->destination }}</div>
            </div>
        </div>

        <div class="text-right">
            <span class="text-4xl font-thin leading-none">{{ '$' . $space->price }}</span>
            <div class="text-xs text-gray-600 font-medium">USD</div>
        </div>
    </div>

    <div>
        <form action="{{ route('checkout.store', $space) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary w-full text-center">Book</button>
        </form>
    </div>
</div>
