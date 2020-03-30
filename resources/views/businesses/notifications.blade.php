@extends('layouts.app')

@section('content')
    <section class="pt-6 pb-12">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="rounded-lg shadow overflow-hidden">
                        <div class="bg-white px-4 sm:px-6 border-b border-gray-300">
                            <div class="flex justify-between items-center">
                                <nav class="-mb-px flex">
                                    <a href="?status=Unread" class="flex items-center {{ request('status') == 'Unread' ? 'border-indigo-500 text-indigo-500' : 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-400' }} whitespace-no-wrap py-5 px-1 border-b-2 font-medium text-sm focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150">
                                        <span>Unread</span>
                                    </a>

                                    <a href="?status=Read" class="flex items-center ml-8 {{ request('status') == 'Read' ? 'border-indigo-500 text-indigo-500' : 'border-transparent text-gray-600 hover:text-gray-700 hover:border-gray-400' }} whitespace-no-wrap py-5 px-1 border-b-2 font-medium text-sm focus:outline-none focus:text-gray-700 focus:border-gray-300 transition ease-in-out duration-150">
                                        <span>Read</span>
                                    </a>
                                </nav>
                            </div>
                        </div>

                        <div class="bg-white px-4 py-5 sm:px-6">
                            <form action="{{ route('users.notifications.search', $user) }}" method="GET">
                                <label for="q" class="sr-only">Search notifications</label>

                                <div class="flex rounded-lg shadow-sm">
                                    <div class="relative flex-grow focus-within:z-10">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>

                                        <input id="q" name="q" type="text" class="form-input bg-white rounded-none block w-full pl-10 pr-3 rounded-l-lg focus:shadow-none transition ease-in-out duration-150" required placeholder="Search notifications...">
                                    </div>

                                    <button type="submit" class="-ml-px relative flex items-center px-3 py-2 rounded-r-lg border border-gray-300 bg-gray-100 text-gray-800 focus:outline-none focus:shadow-none focus:border-blue-300 focus:z-10 transition ease-in-out duration-150">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>

                        @forelse ($notifications as $notification)
                            <div class="bg-white px-4 py-5 sm:px-6 border-b border-gray-300">
                                <div class="row items-start">
                                    <div class="col-12">
                                        <div class="flex items-center">
                                            <div class="min-w-0 flex-1 flex items-center">
                                                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                                    <div>
                                                        <div class="text-xs leading-5 font-semibold tracking-wider text-gray-500 uppercase">New Order Placed</div>

                                                        <div>
                                                            <div>
                                                                Order no. <span class="font-semibold uppercase text-sm">{{ '#' . $notification->data['order']['uid'] }}</span> placed for space <span class="font-semibold uppercase text-sm">{{ '#' . $notification->data['order']['space_id'] }}</span>
                                                            </div>

                                                            <div class="mt-2 text-sm leading-5 font-medium truncate text-indigo-500">{{ $notification->data['order']['name'] }}</div>

                                                            <div class="flex items-center">
                                                                <div class="flex items-center text-sm leading-5 text-gray-500">
                                                                    <svg class="flex-shrink-0 mr-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884zM18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" clip-rule="evenodd"></path>
                                                                    </svg>

                                                                    <span class="truncate">{{ $notification->data['order']['email'] }}</span>
                                                                </div>

                                                                <div class="ml-4 flex items-center text-sm leading-5 text-gray-500">
                                                                    <svg class="flex-shrink-0 mr-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                                    </svg>

                                                                    <span class="truncate">{{ $notification->data['order']['phone'] }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="hidden md:block">
                                                        <div>
                                                            <div class="text-sm leading-5 text-gray-900">
                                                                <time datetime="{{ $notification->created_at->format('Y-m-d') }}">{{ $notification->created_at->format('M j, Y') }}</time>
                                                            </div>

                                                            <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                                <svg class="flex-shrink-0 mr-2 h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                                </svg>

                                                                Pending confirmation
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                @if ($notification->read_at)
                                                    <form action="{{ route('users.notifications.markunread', user()) }}" method="POST">
                                                        @csrf

                                                        <input type="hidden" name="notification" value="{{ $notification->id }}">

                                                        <button type="submit" class="btn btn-secondary text-sm">Mark unread</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('users.notifications.markread', user()) }}" method="POST">
                                                        @csrf

                                                        <input type="hidden" name="notification" value="{{ $notification->id }}">

                                                        <button type="submit" class="btn btn-secondary text-sm">Mark read</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white px-4 py-5 sm:px-6">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>

                                    <span class="text-gray-600">No results found.</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
