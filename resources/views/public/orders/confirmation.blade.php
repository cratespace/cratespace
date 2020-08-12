@extends('layouts.web.base')

@section('content')
    <section class="pt-8 pb-16 bg-white">
        <div class="container">
            <div class="row justify-center">
                <div class="mb-20 lg:mb-0 col-lg-4">
                    <div>
                        <div>
                            <a href="{{ url('/') }}" class="flex justify-center lg:block">
                                <img class="h-8 w-auto" src="{{ asset('img/logo-dark.png') }}" alt="{{ config('app.name') }}" />
                            </a>
                        </div>

                        <div class="mt-8 leading-snug">
                            <span class="text-blue-500 font-semibold">{{ $order->space->uid }}</span>

                            <div>
                                {{ $order->space->present()->businessName }}
                            </div>

                            <div class="mt-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500 text-blue-100">
                                    {{ $order->space->type }}
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

                                <div><span class="font-bold text-gray-700">{{ $order->space->present()->volume }}</span> (cu ft)</div>

                                <div class="text-sm">{{ $order->space->height }} x {{ $order->space->width }} x {{ $order->space->length }} (ft)</div>
                            </div>

                            <div class="mt-6">
                                <div class="flex items-center">
                                    <x:heroicon-o-calendar class="w-4 h-4 text-gray-400"/>

                                    <div class="ml-1 text-xs">Departure</div>
                                </div>

                                <div class="text-gray-700">{{ $order->space->departs_at->format('M j, g:ia') }}</div>

                                <div>from <span class="text-gray-700">{{ $order->space->origin }}</span></div>
                            </div>

                            <div class="mt-6">
                                <div class="flex items-center">
                                    <x:heroicon-o-calendar class="w-4 h-4 text-gray-400"/>

                                    <div class="ml-1 text-xs">Arrival</div>
                                </div>

                                <div class="text-gray-700">{{ $order->space->arrives_at->format('M j, g:ia') }}</div>

                                <div>to <span class="text-gray-700">{{ $order->space->destination }}</span></div>
                            </div>
                        </div>

                        <hr class="my-6">

                        <div>
                            <div class="flex justify-between items-baseline">
                                <div class="font-base">
                                    <span>Original price</span>
                                </div>

                                <div class="text-right">
                                    <span>{{ App\Support\Formatter::money($order->price) }}</span>
                                </div>
                            </div>

                            <div class="mt-2 flex justify-between items-baseline">
                                <div class="font-base">
                                    <span>Estimated Tax</span>
                                </div>

                                <div class="text-right">
                                    <span>{{ App\Support\Formatter::money($order->tax + $order->space->tax) }}</span>
                                </div>
                            </div>

                            <div class="mt-2 flex justify-between items-baseline">
                                <div class="font-base">
                                    <span>Service charges</span>
                                </div>

                                <div class="text-right">
                                    <span>{{ App\Support\Formatter::money($order->service) }}</span>
                                </div>
                            </div>

                            <div class="mt-2 flex justify-between items-baseline">
                                <div class="font-semibold text-gray-700 text-xl">
                                    <span>Total</span>
                                </div>

                                <div class="text-right">
                                    <span class="text-gray-700 text-xl font-semibold">{{ App\Support\Formatter::money($order->total) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 offset-lg-1">
                    <div>
                        <div class="text-blue-600 font-semibold text-sm">{{ '#' . $order->confirmation_number }}</div>
                        <h4><span class="font-normal">Arrives</span> {{ $order->space->arrives_at->format('D, M j') }}</h4>
                    </div>

                    <div class="mt-8">
                        <div class="progress rounded-full overflow-hidden">
                            <div class="progress-bar progress-bar-striped progress-bar-animated rounded-full" role="progressbar" style="width: 29%" aria-valuenow="29" aria-valuemin="0" aria-valuemax="29"></div>
                        </div>

                        <div class="mt-2 flex items-center justify-between text-sm font-medium">
                            <span class="text-gray-700">Order placed</span>
                            <span class="text-gray-700">Processing</span>
                            <span class="text-gray-700">Approved</span>
                            <span class="text-gray-700">Shipped</span>
                            <span class="text-green-500">Delivered</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="text-sm">
                            Tracking information will be available in 24 hours. Tracking system is real-time and does not require the web page to be reloaded.
                        </div>
                    </div>

                    <div>
                        <hr class="my-6">

                        <h5>Payment Information</h5>

                        <div class="mt-4">
                            <p>
                                <div>
                                    Payed with card ending with <span class="ml-1 font-mono tracking-widest rounded-lg px-2 py-1 bg-gray-200 text-sm font-medim">**** **** **** {{ $order->charge->card_last_four }}</span>
                                </div>

                                <div class="mt-2">
                                    Payed total of <span class="font-bold text-blue-500">{{ $order->present()->total }}</span> and payment was <span class="px-2 py-1 text-xs rounded-full font-semibold text-green-800 bg-green-100 uppercase">Successful</span>
                                </div>
                            </p>
                        </div>

                        <hr class="my-6">

                        <h5>Contact Information</h5>

                        <div class="mt-4">
                            <p>
                                <div class="font-medium text-gray-700">{{ $order->name }}</div>
                                <div class="text-blue-500">{{ $order->email }}</div>
                                <div>{{ $order->phone }}</div>
                                <div class="mt-1 font-medium">{{ $order->business }}</div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
