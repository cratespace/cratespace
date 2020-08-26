<div>
    <div class="leading-snug">
        <div class="flex justify-between items-center">
            <span class="text-blue-500 font-semibold">{{ $order->space->code }}</span>

            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500 text-blue-100">
                {{ $order->space->type }}
            </span>
        </div>
    </div>

    <hr class="my-6">

    <div>
        <div class="font-semibold text-gray-800">{{ $business->name }}</div>

        <div class="mt-2">
            <div>
                {{ $business->street }}, {{ $business->city }}
            </div>

            <div>
                {{ $business->state }}, {{ $business->country }}, {{ $business->postcode }}
            </div>
        </div>

        <div class="mt-2">
            <div>
                <a href="mailto:{{ $business->email }}">{{ $business->email }}</a>
            </div>

            <div>
                {{ $business->phone }}
            </div>
        </div>
    </div>

    <hr class="my-6">

    <div>
        <div>
            <div class="flex items-center">
                <x:heroicon-o-arrows-expand class="w-4 h-4 text-gray-400"/>

                <div class="ml-1 text-xs">Dimensions</div>
            </div>

            <div><span class="font-bold text-gray-800">{{ $order->space->present()->volume }}</span> (cu ft)</div>

            <div class="text-sm">{{ $order->space->height }} x {{ $order->space->width }} x {{ $order->space->length }} (ft)</div>
        </div>

        <div class="mt-6">
            <div class="flex items-center">
                <x:heroicon-o-calendar class="w-4 h-4 text-gray-400"/>

                <div class="ml-1 text-xs">Departure</div>
            </div>

            <div class="text-gray-800">
                <time datetime="{{ $order->space->departs_at }}">{{ $order->space->departs_at->format('M j, g:ia') }}</time>
            </div>

            <div>from <span class="text-gray-800">{{ $order->space->origin }}</span></div>
        </div>

        <div class="mt-6">
            <div class="flex items-center">
                <x:heroicon-o-calendar class="w-4 h-4 text-gray-400"/>

                <div class="ml-1 text-xs">Arrival</div>
            </div>

            <div class="text-gray-800">
                <time datetime="{{ $order->space->arrives_at }}">{{ $order->space->arrives_at->format('M j, g:ia') }}</time>
            </div>

            <div>to <span class="text-gray-800">{{ $order->space->destination }}</span></div>
        </div>
    </div>

    <hr class="my-6">

    <div>
        <div class="flex justify-between items-baseline">
            <div class="font-base">
                <span>Original price</span>
            </div>

            <div class="text-right">
                <span>{{ $order->present()->price }}</span>
            </div>
        </div>

        <div class="mt-2 flex justify-between items-baseline">
            <div class="font-base">
                <span>Estimated Tax</span>
            </div>

            <div class="text-right">
                <span>{{ $order->present()->tax }}</span>
            </div>
        </div>

        <div class="mt-2 flex justify-between items-baseline">
            <div class="font-base">
                <span>Service charges</span>
            </div>

            <div class="text-right">
                <span>{{ $order->present()->service }}</span>
            </div>
        </div>

        <div class="mt-2 flex justify-between items-baseline">
            <div class="font-semibold text-gray-800 text-xl">
                <span>Total</span>
            </div>

            <div class="text-right">
                <span class="text-gray-800 text-xl font-semibold">{{ $order->present()->total }}</span>
            </div>
        </div>
    </div>
</div>
