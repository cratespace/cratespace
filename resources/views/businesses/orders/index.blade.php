@extends('layouts.app')

@section('content')
    <section class="pt-6 pb-32 bg-gray-800">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-semibold text-white leading-tight">
                                Orders
                            </h2>

                            <div class="flex items-center text-gray-400">
                                Manage customer orders for your available spaces.
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('spaces.create') }}" class="btn btn-primary flex items-center">
                                <svg class="mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>

                                <span>Place order</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative pt-6 pb-12">
        <div class="container -mt-32">
            <div class="row">
                <div class="col-12">
                    <div class="flex flex-col">
                      <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                        <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                            <div class="bg-white px-4 sm:px-6 border-b border-gray-300">
                                <div class="flex justify-between items-center">
                                    <nav class="-mb-px flex">
                                        <a href="?status=Pending" class="flex items-center {{ request('status') == 'Pending' ? 'border-indigo-500 text-indigo-500' : 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-400' }} whitespace-no-wrap py-5 px-1 border-b-2 font-medium text-sm focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150">
                                            <span>Pending</span>

                                            <span class="ml-2 {{ request('status') == 'Pending' ? 'bg-indigo-200 text-indigo-600' : 'bg-gray-200 text-gray-600' }} inline-block text-xs leading-none px-2 py-1 rounded-full overflow-hidden font-medium">
                                                {{ $counts['pending'] }}
                                            </span>
                                        </a>

                                        <a href="?status=Confirmed" class="flex items-center ml-8 {{ request('status') == 'Confirmed' ? 'border-indigo-500 text-indigo-500' : 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-400' }} whitespace-no-wrap py-5 px-1 border-b-2 font-medium text-sm focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150">
                                            <span>Confirmed</span>

                                            <span class="ml-2 {{ request('status') == 'Confirmed' ? 'bg-indigo-200 text-indigo-600' : 'bg-gray-200 text-gray-600' }} inline-block text-xs leading-none px-2 py-1 rounded-full overflow-hidden font-medium">
                                                {{ $counts['confirmed'] }}
                                            </span>
                                        </a>

                                        <a href="?status=Completed" class="flex items-center ml-8 {{ request('status') == 'Completed' ? 'border-indigo-500 text-indigo-500' : 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-400' }} whitespace-no-wrap py-5 px-1 border-b-2 font-medium text-sm focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150">
                                            <span>Completed</span>

                                            <span class="ml-2 {{ request('status') == 'Completed' ? 'bg-indigo-200 text-indigo-600' : 'bg-gray-200 text-gray-600' }} inline-block text-xs leading-none px-2 py-1 rounded-full overflow-hidden font-medium">
                                                {{ $counts['completed'] }}
                                            </span>
                                        </a>

                                        <a href="?status=Canceled" class="flex items-center ml-8 {{ request('status') == 'Canceled' ? 'border-indigo-500 text-indigo-500' : 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-400' }} whitespace-no-wrap py-5 px-1 border-b-2 font-medium text-sm focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150">
                                            <span>Canceled</span>

                                            <span class="ml-2 {{ request('status') == 'Canceled' ? 'bg-indigo-200 text-indigo-600' : 'bg-gray-200 text-gray-600' }} inline-block text-xs leading-none px-2 py-1 rounded-full overflow-hidden font-medium">
                                                {{ $counts['canceled'] }}
                                            </span>
                                        </a>
                                    </nav>
                                </div>
                            </div>

                            <div class="bg-white px-4 py-5 sm:px-6">
                                <form action="#" method="GET">
                                    <label for="search" class="sr-only">Search orders</label>

                                    <div class="flex rounded-lg shadow-sm">
                                        <div class="relative flex-grow focus-within:z-10">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>

                                            <input id="search" name="search" type="text" class="form-input bg-white rounded-none block w-full pl-10 pr-3 rounded-l-lg focus:shadow-none transition ease-in-out duration-150" required placeholder="Search by order number...">
                                        </div>

                                        <button type="submit" class="-ml-px relative flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-gray-100 text-gray-800 focus:outline-none focus:shadow-none focus:border-blue-300 focus:z-10 transition ease-in-out duration-150">
                                            Search
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b border-t border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                            Cutomer / Space
                                        </th>

                                        <th class="px-6 py-3 border-b border-t border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                            Placed / Due
                                        </th>

                                        <th class="px-6 py-3 border-b border-t border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                            Total
                                        </th>

                                        <th class="px-6 py-3 border-b border-t border-gray-200 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-600 uppercase tracking-wider">
                                            Status
                                        </th>

                                        <th class="px-6 py-3 border-b border-t border-gray-200 bg-gray-100"></th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white">
                                    @forelse ($orders as $order)
                                        <tr is="order" :data="{{ $order }}"></tr>
                                    @empty
                                        <tr>
                                            <td>
                                                <div class="flex items-center ml-6 py-6">
                                                    <svg class="h-5 w-5 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>

                                                    <span class="text-gray-600">No results found</span>
                                                </div>
                                            </td>

                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="bg-white px-4 py-3 flex items-center justify-between sm:px-6">
                                <div class="hidden sm:block">
                                    <p class="text-sm leading-5 text-gray-700">
                                        Showing
                                        <span class="font-medium">{{ $orders->firstItem() }}</span>
                                        to
                                        <span class="font-medium">{{ $orders->lastItem() }}</span>
                                        of
                                        <span class="font-medium">{{ $orders->total() }}</span>
                                        results
                                    </p>
                                </div>

                                <div class="flex-1 flex justify-between sm:justify-end">
                                    {{ $orders->links('components.pagination.default') }}
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
