@extends('layouts.master', ['bgColor' => 'bg-auth bg-contain bg-no-repeat min-h-screen bg-right-top'])

@section('body')
    <section class="py-16 bg-white lg:bg-transparent">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-6 xl:mb-0 flex items-center">
                    @include('public.checkout.sections._summary')
                </div>

                <div class="col-xl-6 col-lg-7 mb-6 bg-gray-200 sm:bg-transparent py-5 sm:py-0 xl:mb-0 offset-xl-1">
                    @include('public.checkout.sections._form')
                </div>
            </div>
        </div>
    </section>
@endsection
