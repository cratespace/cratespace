@extends('layouts.support.base')

@section('content')
    <section class="py-6">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mb-6 pr-16">
                    @yield('body')
                </div>

                <div class="col-lg-4 mb-6">
                    @include('support.threads.components.sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
