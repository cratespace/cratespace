@extends('layouts.support.base')

@section('content')
    <section class="py-6">
        <div class="container">
            <div class="row ">
                <div class="col-lg-8 mb-6 pr-16">
                    <div class="mb-8">
                        <div class="mb-2">
                            <span class="text-3xl text-gray-800">{{ $thread->title }}</span>
                        </div>

                        <div class="text-sm flex lg:flex-row flex-col lg:items-center">
                            <a class="whitespace-no-wrap" href="{{ route('support.threads.index') }}">
                                <span class="mr-1">&larr;</span>
                                <span>Back to threads</span>
                            </a>

                            <span class="mx-2 hidden lg:inline">&middot;</span>

                            <a class="whitespace-no-wrap" href="#">{{ $thread->user->name }}</a>

                            <span class="mx-2 hidden lg:inline">&middot;</span>

                            <span class="text-gray-600 whitespace-no-wrap">{{ $thread->created_at->format('M j, Y') }}</span>

                            <span class="mx-2 hidden lg:inline">&middot;</span>

                            <span class="text-gray-600 flex items-center">
                                <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                </svg>

                                <span>{{ count($thread->replies) }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="mb-20 leading-relaxed markdown">
                        {!! parse($thread->body) !!}
                    </div>
                </div>

                <div class="col-lg-4 mb-6">
                    @include('support.threads.components.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
