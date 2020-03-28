@extends('layouts.app')

@section('content')
    <section class="py-6 bg-gray-800">
        <div class="container">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="mr-4 mb-6 lg:mb-0">
                    <img class="h-20 w-20 rounded-full" src="{{ user()->business->photo }}" alt="{{ user()->business->name }}" />
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

                        @if (user('email_verified_at'))
                            <div class="mt-2 flex items-center text-sm text-gray-300 sm:mr-6">
                                <svg class="flex-shrink-0 mr-2 h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>

                                Verified account
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-6 bg-gray-900">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-6 md:mb-0">
                    <div>
                        <div class="text-gray-400 font-medium text-sm">Credit</div>

                        <div class="flex leading-none items-end">
                            <div class="text-white text-3xl leading-none">$56738.87</div>

                            <div class="ml-2 leading-none flex items-center whitespace-no-wrap">
                                <svg class="flex-shrink-0 h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                                </svg>

                                <span class="text-white ml-1">11% <span class="text-gray-400">since last month</span></span>
                            </div>
                        </div>

                        <div class="mt-2">
                            <a href="#" class="text-sm text-indigo-500 hover:text-indigo-400">View summary <span>&rarr;</span></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 offset-lg-4">
                    <div class="text-gray-400 font-medium text-sm">Pending Orders</div>

                    <div class="flex leading-none items-end">
                        <div class="text-white text-3xl leading-none">{{ $orders['pending'] }}</div>
                    </div>

                    <div class="mt-2">
                        <a href="{{ route('orders.index', ['status' => 'Pending']) }}" class="text-sm text-indigo-500 hover:text-indigo-400">View pending <span>&rarr;</span></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <div class="text-gray-400 font-medium text-sm">Available Spaces</div>

                    <div class="flex leading-none items-end">
                        <div class="text-white text-3xl leading-none">{{ $spaces['available'] }}</div>
                    </div>

                    <div class="mt-2">
                        <a href="{{ route('spaces.index', ['status' => 'Available']) }}" class="text-sm text-indigo-500 hover:text-indigo-400">View available <span>&rarr;</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mb-6 font-semibold text-gray-800 text-xl">Orders This Year</div>
                    <graph :data="{{ $chart->values() }}"></graph>
                </div>
            </div>
        </div>
    </section>
@endsection
