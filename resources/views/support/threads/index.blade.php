@extends('support.threads.layouts.base')

@section('body')
    <div class="mb-4">
        <span class="text-3xl text-gray-800">How can we help?</span>
    </div>

    <form class="mb-12" method="GET" action="#">
        <div class="relative">
            <input type="search" name="q" id="q" class="form-input w-full block bg-white pl-10 py-3 placeholder-gray-400" placeholder="Search threads..." autocomplete="q" autofocus="q">

            <svg class="h-5 w-5 text-gray-600 absolute top-0 left-0 mt-4 ml-3" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
            </svg>
        </div>
    </form>

    <div class="mb-20">
        @forelse ($threads as $thread)
            @include('support.threads.components._thread', ['thread' => $thread])
        @empty
            <span class="text-gray-500">No threads found.</span>
        @endforelse
    </div>

    <div class="flex justify-start items-center">
        {{ $threads->links('components.pagination.default') }}
    </div>
@endsection
