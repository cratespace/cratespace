@extends('layouts.master', ['bgColor' => 'bg-auth bg-contain bg-no-repeat min-h-screen bg-right-top'])

@section('body')
    <section class="py-16 bg-white lg:bg-transparent">
        <div class="container">
            <div class="row">
                @include('public.checkout.sections._summary')

                @include('public.checkout.sections._form')
            </div>
        </div>
    </section>
@endsection
