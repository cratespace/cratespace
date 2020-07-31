@extends('layouts.master', ['bgColor' => 'bg-auth bg-contain bg-no-repeat min-h-screen bg-right-top'])

@section('body')
    <section class="py-16 bg-white lg:bg-transparent">
        <div class="container">
            <div class="mb-8 row">
                <div class="col-12">
                    <span class="px-2 py-1 bg-gray-200 text-gray-800 rounded-lg overflow-hidden font-semibold text-sm">{{ $paymentToken }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5 mb-6 xl:mb-0 flex items-center">
                    <div class="flex-1">
                        <div>
                            <div>
                                <a href="{{ url('/') }}" class="flex justify-center lg:block">
                                    <img class="h-8 w-auto" src="{{ asset('img/logo-dark.png') }}" alt="{{ config('app.name') }}" />
                                </a>
                            </div>

                            <div class="mt-8 leading-snug">
                                <span class="text-blue-500 font-semibold">{{ $space->uid }}</span>

                                <div>
                                    {{ $space->businessName }}
                                </div>

                                <div class="mt-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500 text-blue-100">
                                        {{ $space->type }}
                                    </span>
                                </div>
                            </div>

                            <hr class="my-6">

                            <div>
                                <div>
                                    <div class="flex items-center">
                                        <x:heroicon-o-arrows-expand class="w-4 h-4 text-gray-400"/>

                                        <div class="ml-1 text-xs">Dimensions</div>
                                    </div>

                                    <div><span class="font-bold text-gray-700">{{ $space->present()->volume }}</span> (cu ft)</div>

                                    <div class="text-sm">{{ $space->height }} x {{ $space->width }} x {{ $space->length }} (ft)</div>
                                </div>

                                <div class="mt-6">
                                    <div class="flex items-center">
                                        <x:heroicon-o-calendar class="w-4 h-4 text-gray-400"/>

                                        <div class="ml-1 text-xs">Departure</div>
                                    </div>

                                    <div class="text-gray-700">{{ $space->departs_at->format('M j, g:ia') }}</div>

                                    <div>from <span class="text-gray-700">{{ $space->origin }}</span></div>
                                </div>

                                <div class="mt-6">
                                    <div class="flex items-center">
                                        <x:heroicon-o-calendar class="w-4 h-4 text-gray-400"/>

                                        <div class="ml-1 text-xs">Arrival</div>
                                    </div>

                                    <div class="text-gray-700">{{ $space->arrives_at->format('M j, g:ia') }}</div>

                                    <div>to <span class="text-gray-700">{{ $space->destination }}</span></div>
                                </div>
                            </div>

                            <hr class="my-6">

                            <div>
                                <div class="flex justify-between items-baseline">
                                    <div class="font-base">
                                        <span>Original price</span>
                                    </div>

                                    <div class="text-right">
                                        <span>{{ $charges['price'] }}</span>
                                    </div>
                                </div>

                                <div class="mt-2 flex justify-between items-baseline">
                                    <div class="font-base">
                                        <span>Value Added Tax</span>
                                    </div>

                                    <div class="text-right">
                                        <span>{{ $charges['tax'] }}</span>
                                    </div>
                                </div>

                                <div class="mt-2 flex justify-between items-baseline">
                                    <div class="font-base">
                                        <span>Service charges</span>
                                    </div>

                                    <div class="text-right">
                                        <span>{{ $charges['service'] }}</span>
                                    </div>
                                </div>

                                <div class="mt-2 flex justify-between items-baseline">
                                    <div class="font-semibold text-gray-700 text-xl">
                                        <span>Total</span>
                                    </div>

                                    <div class="text-right">
                                        <span class="text-gray-700 text-xl font-semibold">{{ $charges['total'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-6">

                            <div>
                                <a href="{{ url('/') }}" class="text-xs leading-8">
                                    <span class="text-red-500">Cancel</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-7 mb-6 bg-gray-200 sm:bg-transparent py-5 sm:py-0 xl:mb-0 offset-xl-1">
                    <x-cards._full>
                        <div>
                            <h4>Pay with card</h4>
                        </div>

                        <form action="{{ route('spaces.orders', $space) }}" method="POST">
                            @csrf

                            <input type="hidden" name="payment_token" value="{{ $paymentToken }}">

                            <div class="row">
                                <div class="col-md-6 mt-4">
                                    @include('components.forms.fields._name')
                                </div>

                                <div class="col-md-6 mt-4">
                                    @include('components.forms.fields._business')
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mt-4">
                                    @include('components.forms.fields._email')
                                </div>

                                <div class="col-md-6 mt-4">
                                    @include('components.forms.fields._phone')
                                </div>
                            </div>

                            <div class="mt-4 row">
                                <div class="col-xl-9">
                                    @include('components.forms.fields._credit-card')
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-xs text-gray-600 max-w-sm">
                                    By clicking <span class="font-semibold">Pay</span>, you confirm you have read and agreed to <a href="/terms">{{ config('app.name') }} General Terms and Conditions</a> and <a href="/privacy">Privacy Policy</a>.
                                </p>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="btn btn-primary w-full">
                                    Pay {{ $charges['total'] }}
                                </button>
                            </div>
                        </form>
                    </x-cards._full>
                </div>
            </div>
        </div>
    </section>
@endsection
