@extends('layouts.support.base')

@section('content')
    <section class="py-6">
        <div class="container">
            <div class="row ">
                <div class="col-lg-8 mb-6 pr-16">
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
                            <a href="{{ $thread->path() }}" class="mb-6 flex group whitespace-normal">
                                <div class="h-4 w-4 mt-2">
                                    <svg class="h-4 w-4 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                    </svg>
                                </div>

                                <div class="ml-4 group">
                                    <div class="text-indigo-500 group-hover:text-indigo-400 whitespace-normal">
                                        {{ $thread->title }}
                                    </div>

                                    <div class="mt-2 max-w-2xl">
                                        <p class="text-sm text-gray-600 whitespace-normal leading-relaxed">
                                            {{ get_excerpt(parse($thread->body), 200) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <span class="text-gray-500">No threads found.</span>
                        @endforelse
                    </div>

                    <div class="flex justify-start items-center">
                        {{ $threads->links('components.pagination.default') }}
                    </div>
                </div>

                <div class="col-lg-4 mb-6">
                    @include('support.threads.components.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
