@extends('business.layouts.crm', [
    'pageTitle' => 'Spaces',
    'resourceName' => 'spaces',
    'statuses' => [
        'Available',
        'Ordered',
        'Expired'
    ]
])

@section('crm-content')
    <x-tables._normal>
        <x-slot name="head">
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                Space/Departs
            </th>

            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                Price
            </th>

            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                Status
            </th>

            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                Departs
            </th>

            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                Arrives
            </th>

            <th class="px-6 py-3 border-b border-gray-200 bg-gray-200"></th>
        </x-slot>

        <x-slot name="body">
            @forelse ($resource as $space)
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 bg-gray-100">
                        <div class="mt-1">
                            <div class="text-sm leading-5 text-gray-800 font-semibold">
                                <a href="{{ $space->path }}">{{ $space->uid }}</a>
                            </div>

                            <div class="text-xs leading-5">{{ 'Added ' . $space->created_at->diffForHumans() }}</div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 bg-gray-100 text-sm leading-4">
                        <div class="font-bold text-gray-800">{{ $space->price }}</div>
                        <span class="text-xs">USD</span>
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 bg-gray-100">
                        <span class="px-2 inline-flex text-sm leading-5 font-medium rounded-full bg-blue-100 text-blue-800">
                            {{ $space->status }}
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 bg-gray-100 text-sm leading-5">
                        <div>{{ $space->schedule->departsAt }}</div>
                        <div class="text-xs">{{ $space->departs_at->diffForHumans() }}</div>
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 bg-gray-100 text-sm leading-5">
                        <div>{{ $space->schedule->arrivesAt }}</div>
                        <div class="text-xs">{{ $space->arrives_at->diffForHumans() }}</div>
                    </td>

                    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 bg-gray-100 text-sm leading-5 font-medium">
                        <a href="#">Manage</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap text-left border-b border-gray-200 text-sm leading-5 font-medium">
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
