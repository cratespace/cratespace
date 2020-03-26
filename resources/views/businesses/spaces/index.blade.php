@extends('layouts.app')

@section('content')
    <section class="pt-6 pb-32 bg-gray-800">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-semibold text-white leading-tight">
                                Spaces
                            </h2>

                            <div class="flex items-center text-gray-400">
                                Add and manage your available spaces.
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('spaces.create') }}" class="btn btn-primary flex items-center">
                                <svg class="mr-1 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>

                                <span>Add space</span>
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
                    <div class="overflow-auto shadow rounded-lg">
                        <div class="rounded-lg overflow-hidden">
                            <div class="bg-white px-4 sm:px-6 border-b border-gray-300">
                                <div class="flex justify-between items-center">
                                    <nav class="-mb-px flex">
                                        <a href="?status=Available" class="{{ request('status') == 'Available' ? 'border-indigo-500 text-indigo-500' : 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-400' }} whitespace-no-wrap py-5 px-1 border-b-2 font-medium text-sm focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150">
                                            Available
                                        </a>

                                        <a href="?status=Ordered" class="ml-8 {{ request('status') == 'Ordered' ? 'border-indigo-500 text-indigo-500' : 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-400' }} whitespace-no-wrap py-5 px-1 border-b-2 font-medium text-sm focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150">
                                            Ordered
                                        </a>

                                        <a href="?status=Completed" class="ml-8 {{ request('status') == 'Completed' ? 'border-indigo-500 text-indigo-500' : 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-400' }} whitespace-no-wrap py-5 px-1 border-b-2 font-medium text-sm focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150">
                                            Completed
                                        </a>

                                        <a href="?status=Expired" class="ml-8 {{ request('status') == 'Expired' ? 'border-indigo-500 text-indigo-500' : 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-400' }} whitespace-no-wrap py-5 px-1 border-b-2 font-medium text-sm focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150">
                                            Expired
                                        </a>
                                    </nav>

                                    <div class="dropdown">
                                        <button class="whitespace-no-wrap ml-8 py-5 px-1 border-b-2 border-transparent font-medium text-sm text-gray-600 hover:text-gray-700 hover:border-gray-400 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150 flex items-center" id="typeDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span>{{ request('type') ?? 'All' }} shipping</span>

                                            <svg class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right rounded-lg shadow-lg z-50 mt-3" aria-labelledby="typeDropDown">
                                            <a href="{{ route('spaces.index') }}" class="dropdown-item block px-4 py-2 text-sm">All</a>

                                            @foreach (config('shipping.types') as $type)
                                                <a href="{{ route('spaces.index', ['type' => $type]) }}" class="dropdown-item block px-4 py-2 text-sm">{{ $type }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white px-4 py-5 sm:px-6">
                                <form action="{{ route('spaces.index', ['type' => request('type')->slug ?? null]) }}" method="GET">
                                    <label for="search" class="sr-only">Search spaces</label>

                                    <div class="flex rounded-lg shadow-sm">
                                        <div class="relative flex-grow focus-within:z-10">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>

                                            <input id="search" name="search" type="text" class="form-input bg-white rounded-none block w-full pl-10 pr-3 rounded-l-lg focus:shadow-none transition ease-in-out duration-150" required placeholder="Search by space ID...">
                                        </div>

                                        <button type="submit" class="-ml-px relative flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-gray-100 text-gray-800 focus:outline-none focus:shadow-none focus:border-blue-300 focus:z-10 transition ease-in-out duration-150">
                                            Search
                                        </button>
                                    </div>
                                </form>
                            </div>

                            @forelse ($spaces as $space)
                                <div class="bg-white px-4 py-5 sm:px-6 border-b border-gray-300">
                                    <div class="row items-start">
                                        <div class="col-md-4">
                                            <div class="flex justify-between">
                                                <div>
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-600 uppercase">{{ '#' . $space->uid }}</div>

                                                        <div class="text-xs text-indigo-500">{{ $space->type }}</div>
                                                    </div>

                                                    <div class="mt-3">
                                                        <div class="flex items-center">
                                                            <div class="mr-6">
                                                                <div class="flex items-center">
                                                                    <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z"/>
                                                                        <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z"/>
                                                                    </svg>

                                                                    <span class="text-xs text-gray-600">Dimensions</span>
                                                                </div>

                                                                <div class="flex text-xl">
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
                                                                <div class="flex items-center">
                                                                    <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd"/>
                                                                    </svg>

                                                                    <span class="text-xs text-gray-600">M.A.W</span>
                                                                </div>

                                                                <div class="text-xl">
                                                                    {{ $space->weight }} <span class="text-sm text-gray-600">Kg</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mt-3">
                                                        <div class="flex items-center">
                                                            <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                            </svg>

                                                            <span class="text-xs text-gray-600">Price</span>
                                                        </div>

                                                        <div class="text-xl">
                                                            {{ '$' . $space->price }} <span class="text-sm text-gray-600">USD</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="block md:hidden text-right">
                                                    <span class="text-4xl font-thin leading-none">{{ '$' . $space->price }}</span>

                                                    <div class="text-xs text-gray-600 font-medium">USD</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-4 md:mt-0">
                                            <div>
                                                <div class="flex items-center">
                                                    <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                    </svg>

                                                    <div class="text-xs text-gray-600">Country based in</div>
                                                </div>

                                                <div class="text-sm">{{ $space->base }}</div>
                                            </div>

                                            <div class="mt-3">
                                                <div class="flex items-center">
                                                    <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                    </svg>

                                                    <div class="text-xs text-gray-600">Origin</div>
                                                </div>

                                                <div class="text-sm">{{ $space->origin }}</div>
                                            </div>

                                            <div class="mt-3">
                                                <div class="flex items-center">
                                                    <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                                    </svg>

                                                    <div class="text-xs text-gray-600">Destination</div>
                                                </div>

                                                <div class="text-sm">{{ $space->destination }}</div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-4 md:mt-0">
                                            <div class="flex justify-between items-end md:items-start">
                                                <div>
                                                    <div class="text-sm">
                                                        <div>
                                                            <div class="flex items-center">
                                                                <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                                </svg>

                                                                <div class="text-xs text-gray-600">Departs</div>
                                                            </div>
                                                            <div class="text-indigo-500 font-medium">{{ $space->departs_at->format('M j, Y') }}</div>
                                                        </div>

                                                        <div class="text-xs text-gray-600">
                                                            {{ $space->departs_at->diffForHumans() }}
                                                        </div>
                                                    </div>

                                                    <div class="text-sm mt-3">
                                                        <div>
                                                            <div class="flex items-center">
                                                                <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                                </svg>

                                                                <div class="text-xs text-gray-600">Arrives</div>
                                                            </div>
                                                            <div class="text-indigo-500 font-medium">{{ $space->arrives_at->format('M j, Y') }}</div>
                                                        </div>

                                                        <div class="text-xs text-gray-600">
                                                            {{ $space->arrives_at->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="dropdown ml-auto">
                                                        <button class="dropdown-toggle focus:outline-none" id="userDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <svg class="h-6 w-6 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                                            </svg>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-right rounded-lg shadow-lg z-50 mt-3" aria-labelledby="userDropDown">
                                                            <a href="{{ $space->path() }}" class="dropdown-item font-medium block px-4 py-2 text-sm">View</a>
                                                            <a href="{{ route('spaces.edit', $space) }}" class="dropdown-item font-medium block px-4 py-2 text-sm">Edit</a>
                                                            <a href="#" class="dropdown-item font-medium block px-4 py-2 text-sm text-red-500 hover:text-red-500 focus:text-white" data-toggle="modal" data-target="#deleteModal{{ $space->uid }}">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    @include('businesses.spaces.components.modals._delete-confirmation', ['space' => $space])
                                </div>
                            @empty
                                <div class="bg-white px-4 py-5 sm:px-6">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>

                                        <span class="text-gray-600">No results found</span>
                                    </div>
                                </div>
                            @endforelse

                            <div class="bg-white px-4 py-3 flex items-center justify-between sm:px-6">
                                <div class="hidden sm:block">
                                    <p class="text-sm leading-5 text-gray-700">
                                        Showing
                                        <span class="font-medium">{{ $spaces->firstItem() }}</span>
                                        to
                                        <span class="font-medium">{{ $spaces->lastItem() }}</span>
                                        of
                                        <span class="font-medium">{{ $spaces->total() }}</span>
                                        results
                                    </p>
                                </div>

                                <div class="flex-1 flex justify-between sm:justify-end">
                                    {{ $spaces->links('components.pagination.default') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-600">Showing {{ $spaces->firstItem() }} to {{ $spaces->lastItem() }} of {{ $spaces->total() }}</span>
                        </div>

                        <div>
                            {{ $spaces->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
@endsection
