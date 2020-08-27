@extends('layouts.web.base')

@section('content')
    <section class="pt-8 pb-16 bg-white">
        <div class="container">
            <div class="row justify-center">
                <div class="mb-20 lg:mb-0 col-md-5 col-lg-4">
                    @include('public.orders.sections._purchase-details')
                </div>

                <div class="col-md-7 offset-lg-1">
                    @include('public.orders.sections._order-details')
                </div>
            </div>
        </div>
    </section>
@endsection
