@extends('layouts.app')

@section('content')
    <section class="py-6 bg-gray-800">
        <div class="container">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="mr-4 mb-6 lg:mb-0">
                    <img class="h-20 w-20 rounded-full" src="{{ user()->photo }}" alt="{{ user()->name }}" />
                </div>

                <div class="flex-1 min-w-0">
                    <div>
                        <h6 class="text-sm text-gray-300">
                            {{ greet() . ', ' . user()->name }}
                        </h6>

                        <h2 class="text-xl font-bold text-white sm:text-2xl leading-tight">
                            {{ user()->business->name }}
                        </h2>
                    </div>

                    <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap">
                        <div class="mt-2 flex items-center text-sm text-gray-300 sm:mr-6">
                            <svg class="flex-shrink-0 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>

                            {{ user()->business->email }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-gray-900">
        <div class="container">
            <div class="row">
                <div class="col-12">

                </div>
            </div>
        </div>
    </section>

    <section class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-4 flex flex-col mb-6 md:mb-0">
                    <div class="rounded-lg overflow-hidden shadow flex flex-col flex-1">
                        <div class="bg-white px-4 py-5 sm:px-6">
                            <div class="flex items-start lg:items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="flex items-center justify-center h-16 w-16 rounded-lg bg-indigo-500 text-white">
                                        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div>
                                    <div class="text-sm font-medium text-gray-600 leading-tight">Resources</div>

                                    <div class="flex items-end md:flex-col md:items-start lg:flex-row lg:items-end">
                                        <div class="text-4xl font-semibold text-gray-800 leading-tight mr-3">
                                            120
                                        </div>

                                        <div class="flex items-center text-sm text-green-500 font-semibold pb-2">
                                            <span>&uarr;</span>

                                            <span>15%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-100 px-4 py-3 sm:px-6">
                            <a href="#" class="text-sm text-indigo-500 hover:text-indigo-400">View all <span class="ml-1">&rarr;</span></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 flex flex-col mb-6 md:mb-0">
                    <div class="rounded-lg overflow-hidden shadow flex flex-col flex-1">
                        <div class="bg-white px-4 py-5 sm:px-6">
                            <div class="flex items-start lg:items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="flex items-center justify-center h-16 w-16 rounded-lg bg-indigo-500 text-white">
                                        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div>
                                    <div class="text-sm font-medium text-gray-600 leading-tight">Resources</div>

                                    <div class="flex items-end md:flex-col md:items-start lg:flex-row lg:items-end">
                                        <div class="text-4xl font-semibold text-gray-800 leading-tight mr-3">
                                            120
                                        </div>

                                        <div class="flex items-center text-sm text-green-500 font-semibold pb-2">
                                            <span>&uarr;</span>

                                            <span>15%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-100 px-4 py-3 sm:px-6">
                            <a href="#" class="text-sm text-indigo-500 hover:text-indigo-400">View all <span class="ml-1">&rarr;</span></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 flex flex-col">
                    <div class="rounded-lg overflow-hidden shadow flex flex-col flex-1">
                        <div class="bg-white px-4 py-5 sm:px-6">
                            <div class="flex items-start lg:items-center">
                                <div class="flex-shrink-0 mr-4">
                                    <div class="flex items-center justify-center h-16 w-16 rounded-lg bg-indigo-500 text-white">
                                        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div>
                                    <div class="text-sm font-medium text-gray-600 leading-tight">Resources</div>

                                    <div class="flex items-end md:flex-col md:items-start lg:flex-row lg:items-end">
                                        <div class="text-4xl font-semibold text-gray-800 leading-tight mr-3">
                                            120
                                        </div>

                                        <div class="flex items-center text-sm text-green-500 font-semibold pb-2">
                                            <span>&uarr;</span>

                                            <span>15%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-100 px-4 py-3 sm:px-6">
                            <a href="#" class="text-sm text-indigo-500 hover:text-indigo-400">View all <span class="ml-1">&rarr;</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
