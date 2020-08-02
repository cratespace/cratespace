<div class="flex items-center justify-between">
    <span class="inline-flex items-center">
        <span class="px-2 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center">
            <span class="text-xs font-medium">{{ count($spacesDeparting) }}</span>
        </span>

        <span class="ml-2 uppercase tracking-wide text-xs font-normal text-gray-600">Spaces Departing Today</span>
    </span>

    <a class="text-xs" href="{{ route('spaces.index', ['status' => 'Expired']) }}">View all departing <span class="ml-1">&rarr;</span></a>
</div>

<hr class="mt-2 mb-4">

<ul>
    @forelse ($spacesDeparting as $space)
        <li class="mb-3 rounded-lg shadow overflow-hidden">
            <a href="/" class="block bg-white px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="leading-5 text-blue-500 font-semibold">
                        {{ '#' . $space->uid }}
                    </div>

                    <span class="px-2 inline-flex text-sm leading-5 font-medium rounded-full bg-blue-100 text-blue-800">
                        {{ $space->status }}
                    </span>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div>
                        <div>
                            <div>
                                <span class="font-bold text-gray-800">25</span> <span class="text-gray-500">(cu ft)</span>
                            </div>

                            <div class="text-sm text-gray-600">5 x 6 x 2 (ft)</div>

                            <div class="mt-2">
                                <div class="text-gray-800 font-bold">
                                    {{ $space->price }} <span class="text-xs font-normal text-gray-500">USD</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <x:heroicon-o-calendar class="w-4 h-4 text-gray-400"/>

                            <div class="ml-1 text-xs">Departure</div>
                        </div>

                        <div class="text-sm text-gray-700 font-medium">{{ $space->schedule->departsAt }}</div>

                        <div class="text-sm text-gray-700">from <span class="font-medium">{{ $space->origin }}</span></div>
                    </div>

                    <div>
                        <div class="flex items-center">
                            <x:heroicon-o-calendar class="w-4 h-4 text-gray-400"/>

                            <div class="ml-1 text-xs">Arrival</div>
                        </div>

                        <div class="text-sm text-gray-700 font-medium">{{ $space->schedule->arrivesAt }}</div>

                        <div class="text-sm text-gray-700">to <span class="font-medium">{{ $space->destination }}</span></div>
                    </div>
                </div>
            </a>
        </li>
    @empty
        <li class="mb-3">
            <span class="text-sm text-gray-500 font-medium">No spaces pending</span>
        </li>
    @endforelse
</ul>
