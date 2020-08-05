@extends('layouts.web.base', ['bgColor' => 'bg-gray-200'])

@section('content')
    <section class="py-16">
        <div class="container">
            <div class="row justify-center">
                <div class="col-md-5">
                    <div class="text-center text-green-500">
                        {{ $order->uid }}
                        {{ $order->uid }}
                        {{ $order->name }}
                        {{ $order->email }}
                        {{ $order->phone }}
                        {{ $order->total }}
                        {{ $order->created_at }}
                        {{ $order->space->uid }}
                        {{ $order->space->origin }}
                        {{ $order->space->destination }}
                        {{ $order->space->departs_at }}
                        {{ $order->space->arrives_at }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
