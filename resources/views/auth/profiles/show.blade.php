@extends('layouts.app')

@section('content')
    <section class="py-6 bg-gray-800">
        <div class="container">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="mr-4 mb-6 lg:mb-0">
                    <img class="h-20 w-20 rounded-full" src="{{ $user->photo }}" alt="{{ $user->name }}" />
                </div>

                <div class="flex-1 min-w-0">
                    <div>
                        <h6 class="text-sm text-gray-300">
                            {{ greet() . ',' }}
                        </h6>

                        <h2 class="text-xl font-bold text-white sm:text-2xl leading-tight">
                            {{ $user->name }}
                        </h2>
                    </div>

                    <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap">
                        @if ($user->business->name ?? null)
                            <div class="mt-2 flex items-center text-sm text-gray-300 sm:mr-6">
                                <svg class="flex-shrink-0 mr-2 h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                                </svg>

                                {{ $user->business->name }}
                            </div>
                        @endif

                        <div class="mt-2 flex items-center text-sm text-gray-300 sm:mr-6">
                            <svg class="flex-shrink-0 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>

                            {{ $user->email }}
                        </div>

                        <div class="mt-2 flex items-center text-sm text-gray-300">
                            <svg class="flex-shrink-0 mr-2 h-5 w-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            Member since {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-10">
                    <span class="relative inline-block px-3 py-1 font-semibold text-indigo-900 leading-tight text-sm">
                        <span aria-hidden="" class="absolute inset-0 bg-indigo-200 opacity-50 rounded-full"></span>
                        <span class="relative">February 17, 2020</span>
                    </span>

                    <div class="flex">
                        <div class="relative w-16 mr-2">
                            <div class="mx-auto w-1 h-full bg-indigo-200 opacity-50">
                            </div>

                            <span class="absolute inset-x-0 inset-y-0 m-auto block w-4 h-4 bg-indigo-500 border-2 border-gray-200 rounded-full"></span>
                        </div>

                        <div class="flex-1 shadow bg-white rounded-lg px-4 py-5 sm:px-6 my-4">
                            <div>
                                <div class="text-base font-medium">
                                    You marked incomplete a task Impedit aliquam ut eum dignissimos et.
                                </div>

                                <div class="mt-1">
                                    <div class="text-sm text-gray-400">
                                        2 weeks ago
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
