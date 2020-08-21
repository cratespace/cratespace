@extends('business.layouts.crm', [
    'pageTitle' => 'Orders',
    'resourceName' => 'orders',
    'statuses' => config('defaults.orders.statuses')
])

@section('crm-content')
    <x-tables._normal>
        <x-slot name="head">
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                Order/Customer
            </th>

            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                Space/Departs
            </th>

            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                Total
            </th>

            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                Status
            </th>

            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                Placed
            </th>

            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200"></th>
        </x-slot>

        <x-slot name="body">
            @forelse ($resource as $order)
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 bg-gray-100">
                        <div class="flex items-center">
                            <div>
                                <div class="text-sm leading-5 text-gray-800 font-semibold">
                                    <a href="{{ $order->space->path }}">{{ '#' . $order->confirmation_number }}</a>
                                </div>

                                <div class="mt-1 text-sm leading-5 font-medium text-gray-800">{{ $order->name }}</div>

                                <div class="text-sm leading-5">{{ $order->phone }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 bg-gray-100">
                        <div class="mt-1">
                            <div class="text-sm leading-5 text-gray-800 font-semibold">
                                <a href="{{ $order->space->path }}">{{ $order->space->code }}</a>
                            </div>

                            <div class="text-xs leading-5">{{ $order->space->departs_at->diffForHumans() }}</div>

                            <div class="text-xs leading-5">{{ $order->space->schedule->departsAt }}</div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 bg-gray-100 text-sm leading-4">
                        <div class="font-bold text-gray-800">{{ $order->present()->total }}</div>
                        <span class="text-xs">USD</span>
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 bg-gray-100">
                        <span class="px-2 inline-flex text-sm leading-5 font-medium rounded-full bg-{{ $order->present()->status['color'] }}-100 text-{{ $order->present()->status['color'] }}-800">
                            {{ $order->present()->status['text'] }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 bg-gray-100 text-sm leading-5">
                        <div>{{ $order->created_at->format('M j, Y') }}</div>
                        <div class="text-xs">{{ $order->created_at->format('g:ia') }}</div>
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 bg-gray-100 text-sm leading-5 font-medium">
                        <a href="{{ $order->space->path }}">Manage</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap text-left border-b border-gray-200 bg-gray-100 text-sm leading-5 font-medium">
                        No results found.
                    </td>

                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforelse
        </x-slot>

        <x-slot name="pagination">
            {{ $resource->withQueryString()->links() }}
        </x-slot>
    </x-tables._normal>
@endsection
