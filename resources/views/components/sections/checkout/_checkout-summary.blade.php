<div>
    <h3 class="text-xl text-gray-800 font-semibold">Summary</h3>
</div>

<hr class="mt-6 mb-3">

<div>
    <div class="flex justify-between">
        <div class="mb-4">
            <div class="mb-4 flex items-center">
                <div class="mr-3">
                    <img class="h-12 w-12 rounded-full" src="{{ $space->present()->business->photo }}" alt="{{ $space->present()->business->name }}" />
                </div>

                <div>
                    <div class="text-gray-800 font-semibold">{{ $space->present()->business->name }}</div>

                    <div class="text-xs font-bold text-gray-600 uppercase">{{ '#' . $space->uid }}</div>
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
                            <div class="text-indigo-500 font-medium">{{ $space->departs_at->format('M jS, g:i a') }}</div>
                        </div>

                        <div class="text-xs text-gray-600">
                            {{ $space->departs_at->diffForHumans() }}
                        </div>
                    </div>

                    <div class="text-sm">
                        <div>
                            <span class="text-xs text-gray-600">Arrives</span>
                            <div class="text-indigo-500 font-medium">{{ $space->arrives_at->format('M jS, g:i a') }}</div>
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
</div>

<hr class="mb-6 mt-3">

<div class="mb-6">
    <div class="flex justify-between itesm-center mb-4">
        <div>
            <div class="font-base">
                Service charges
            </div>
        </div>

        <div>
            <div class="text-right">
                <span class="font-normal leading-none">{{ '$' . $pricing['service'] }}</span>
            </div>
        </div>
    </div>

    <div class="flex justify-between itesm-center mb-4">
        <div>
            <div class="font-base">
                Tax
            </div>
        </div>

        <div>
            <div class="text-right">
                <span class="font-normal leading-none">{{ '$' . $pricing['tax'] }}</span>
            </div>
        </div>
    </div>

    <div class="flex justify-between itesm-center">
        <div>
            <div class="font-bold">
                Total
            </div>
        </div>

        <div>
            <div class="text-right">
                <span class="text-2xl font-normal leading-none">
                    {{ '$' . $pricing['total'] }}
                </span>
            </div>
        </div>
    </div>
</div>

<div>
    <p class="text-sm text-gray-500 max-w-sm mb-4">You can only purchase one space at a time. The shipper will reach out to you after you've confirmed your purchase.</p>

    <div>
        <a href="{{ route('checkout.destroy') }}" class="text-sm text-red-500 hover:text-red-400 mr-4">Cancel</a>
        <a href="{{ route('welcome') }}" class="text-sm text-indigo-500 hover:text-indigo-400 mr-4">Change</a>
    </div>
</div>
