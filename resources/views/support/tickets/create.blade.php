@extends('layouts.web.base')

@section('content')
    <section class="pt-8 pb-16 bg-white">
        <div class="container">
            <div class="row">
                <div class="mb-10 col-md-7">
                    <div>
                        <h3 class="leadin-snug">
                            Contact support
                        </h3>

                        <div class="mt-6">
                            <form action="{{ route('tickets.store') }}" method="POST">
                                @csrf

                                @include('support.tickets.sections._form')

                                <hr class="my-8">

                                <div>
                                    <button class="btn btn-primary">Submit ticket</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mb-10 col-md-4 offset-md-1 col-lg-3 offset-lg-2">
                    @include('support.partials._sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
