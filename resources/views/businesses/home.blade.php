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
@endsection
