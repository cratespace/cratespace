@extends('layouts.web.base')

@section('content')
    <section class="pt-8 pb-16 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div>
                        @include('support.tickets.sections._main-thread')

                        @include('support.tickets.sections._make-reply')

                        <div class="my-20">
                            @include('support.tickets.sections._replies')
                        </div>

                        <hr class="my-10">

                        <div>
                            @include('support.tickets.sections._related-threads')
                        </div>
                    </div>
                </div>

                <div class="col-md-4 offset-md-1 col-lg-3 offset-lg-2">
                    @include('support.partials._sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
