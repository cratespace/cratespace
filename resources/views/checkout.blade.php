@extends('layouts.web.base')

@section('content')
    <section class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 mb-6 md:mb-0">
                    @include('components.forms._checkout', ['space' => $space])
                </div>

                <div class="col-lg-5 offset-lg-1 col-md-6 mb-6 md:mb-0">
                    @include('components.sections.checkout._checkout-summary', ['space' => $space])
                </div>
            </div>
        </div>
    </section>
@endsection
