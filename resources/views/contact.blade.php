@extends('layouts.web.base')

@section('content')
    @include('components.sections.contact._header')

    <section class="pt-12 pb-16">
        <div class="container">
            @include('components.sections.contact._details')

            <div class="row">
                <div class="col-12">
                    <hr class="mt-10 mb-20">
                </div>
            </div>

            @include('components.sections.contact._locations')
        </div>
    </section>
@endsection
