<div class="flex items-center justify-between">
    <span class="inline-flex items-center">
        <span class="px-2 bg-blue-200 text-blue-800 rounded-full flex items-center justify-center">
            <span class="text-xs font-medium">{{ count($pendingOrders) }}</span>
        </span>

        <span class="ml-2 uppercase tracking-wide text-xs font-normal text-gray-600">Pending Orders</span>
    </span>

    <a class="text-xs" href="{{ route('orders.index', ['status' => 'Pending']) }}">View all pending <span class="ml-1">&rarr;</span></a>
</div>

<hr class="mt-2 mb-4">

<ul>
    @forelse ($pendingOrders as $order)
        <li class="mb-3 rounded-lg overflow-hidden">
            <a href="/" class="block bg-gray-100 px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm leading-5 text-blue-500 font-semibold">
                            {{ '#' . $order->uid }}
                        </div>

                        <div class="mt-1 text-sm leading-5 font-medium text-gray-800">{{ $order->name }}</div>

                        <div class="text-sm leading-5">{{ $order->phone }}</div>
                    </div>

                    <div>
                        <div class="text-sm leading-5 text-gray-800 font-semibold">
                            <span>{{ $order->space->uid }}</span>
                        </div>

                        <div class="text-xs text-gray-600 leading-5">{{ $order->space->departs_at->diffForHumans() }}</div>

                        <div class="text-xs text-gray-600 leading-5">{{ $order->space->schedule->departsAt }}</div>
                    </div>

                    <div class="text-right">
                        <div>
                            <span class="px-2 inline-flex text-sm leading-5 font-medium rounded-full bg-yellow-100 text-yellow-800">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="mt-2 leading-none">
                            <div class="font-bold text-gray-800">{{ $order->present()->total }}</div>
                            <span class="text-xs text-gray-600">USD</span>
                        </div>
                    </div>
                </div>
            </a>
        </li>
    @empty
        <li class="mb-3">
            <span class="text-sm text-gray-500 font-medium">No orders pending</span>
        </li>
    @endforelse
</ul>
