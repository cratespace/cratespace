@extends('layouts.app.base')

@section('content')
    <section class="py-8">
        <div class="container">
            <div class="row items-center">
                <div class="col-lg-4 col-md-6">
                    <div>
                        <h4>
                            Orders
                        </h4>

                        <p class="text-sm max-w-sm">
                            Showing a total of {{ $orders->total() }} orders
                        </p>
                    </div>
                </div>

                <div class="mt-4 md:mt-0 col-lg-4 offset-lg-4 col-md-6">
                    <form class="relative" action="{{ null }}" method="GET">
                        <input type="text" name="search" id="search" class="pl-10 form-input w-full block bg-white" placeholder="Search..." value="{{ old('search', request('search')) }}" required autocomplete="search">

                        <div class="absolute top-0 left-0 bottom-0 flex items-center px-3">
                            <x:heroicon-o-search class="w-5 h-5 text-gray-600"/>
                        </div>

                        <div class="absolute top-0 right-0 bottom-0 flex items-center px-3">
                            <a href="{{ route('orders.index') }}" class="hover:opacity-100 opacity-50">
                                <x:heroicon-o-x-circle class="w-5 h-5 text-gray-600"/>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <hr class="my-6">

            <div class="row">
                <div class="col-12">
                    <x-tables._normal>
                        <x-slot name="head">
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                                Order/Customer
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                                Space/Departs
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                                Total
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                                Status
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium uppercase tracking-wider">
                                Placed
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-100"></th>
                        </x-slot>

                        <x-slot name="body">
                            @forelse ($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm leading-5 text-gray-800 font-semibold">
                                                    <a href="#">{{ '#' . $order->uid }}</a>
                                                </div>

                                                <div class="mt-1 text-sm leading-5 font-medium text-gray-800">{{ $order->name }}</div>

                                                <div class="text-sm leading-5">{{ $order->phone }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="mt-1">
                                            <div class="text-sm leading-5 text-gray-800 font-semibold">
                                                <a href="{{ $order->space->path }}">{{ $order->space->uid }}</a>
                                            </div>

                                            <div class="text-xs leading-5">{{ $order->space->departs_at->diffForHumans() }}</div>

                                            <div class="text-xs leading-5">{{ $order->space->schedule->departsAt }}</div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-4">
                                        <div class="font-bold text-gray-800">{{ $order->present()->total }}</div>
                                        <span class="text-xs">USD</span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <span class="px-2 inline-flex text-sm leading-5 font-medium rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $order->status }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5">
                                        <div>{{ $order->created_at->format('M j, Y') }}</div>
                                        <div class="text-xs">{{ $order->created_at->format('g:ia') }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
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
                            {{ $orders->links() }}
                        </x-slot>
                    </x-tables._normal>
                </div>
            </div>
        </div>
    </section>
@endsection
