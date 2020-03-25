{{-- <tr>
    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-16 w-16">
                <div class="flex justify-center items-center h-16 w-16 bg-indigo-100 rounded-full">
                    <div class="text-center">
                        <div class="text-xs font-semibold text-indigo-900">{{ '#' . $order->uid }}</div>
                    </div>
                </div>
            </div>

            <div class="ml-4">
                <div class="text-sm leading-5 font-medium text-gray-900">{{ $order->name }}</div>
                <div class="text-sm leading-5 text-gray-600">{{ $order->phone }}</div>

                <div>
                    <a href="" class="font-semibold text-indigo-500 text-xs">{{ '#' . $order->space->uid }}</a>
                </div>
            </div>
        </div>
    </td>

    <td class="px-6 py-4 whitespace-no-wrap border-b text-sm leading-5 border-gray-200">
        <div class="text-gray-800 whitespace-no-wrap">{{ $order->created_at->format('M j, Y') }}</div>

        <div class="text-gray-600 whitespace-no-wrap">{{ $order->space->departs_at->diffForHumans() }}</div>
    </td>

    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-600">
        <div class="text-gray-900 whitespace-no-wrap">{{ '$' . $order->total }}</div>
        <div class="text-gray-600 whitespace-no-wrap">USD</div>
    </td>

    <td class="px-6 py-4 whitespace-no-wrap text-sm border-b border-gray-200">
        @include('businesses.orders.components._status', ['status' => $order->status])
    </td>

    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
        @if ($order->status == 'Confirmed' || $order->status == 'Pending')
            <div class="dropdown ml-auto">
                <button class="dropdown-toggle focus:outline-none" id="userDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg class="h-6 w-6 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </button>

                <div class="dropdown-menu dropdown-menu-right rounded-lg shadow-lg z-50 mt-3" aria-labelledby="userDropDown">
                    @if ($order->status == 'Pending')
                        <a href="#" class="dropdown-item font-medium block px-4 py-2 text-sm">Confirm</a>
                    @endif

                    @if ($order->status == 'Confirmed')
                        <a href="#" class="dropdown-item font-medium block px-4 py-2 text-sm">Completed</a>
                    @endif

                    <a href="#" class="dropdown-item font-medium block px-4 py-2 text-sm text-red-500 hover:text-red-500 focus:text-white" data-toggle="modal" data-target="#deleteModal{{ $order->uid }}">Cancel</a>
                </div>
            </div>
        @endif
    </td>
</tr> --}}
