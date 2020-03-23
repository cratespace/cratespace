@extends('layouts.web')

@section('content')
    <section class="bg-gray-200">
        <div class="bg-gray-800 pt-12 pb-40">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="text-center">
                            <p class="text-base text-gray-300 font-semibold tracking-wide uppercase">Browse Spaces</p>

                            <h3 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                                Where will you be shipping today?
                            </h3>

                            <p class="max-w-2xl text-xl text-gray-300 lg:mx-auto">
                                Now shipping becomes easy with us
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container -mt-32">
            <div class="row">
                <div class="col-12">
                    @include('components.forms._filter', ['filters' => $filters])
                </div>
            </div>
        </div>
    </section>

    <section class="pt-12 pb-6 bg-gray-200">
        <div class="container">
            <div class="row">
                @forelse ($spaces as $space)
                    <div class="col-xl-4 col-md-6 flex flex-col">
                        @include('components.cards._listing', ['space' => $space])
                    </div>
                @empty
                    <div class="col">
                        No spaces available.
                    </div>
                @endforelse
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="flex justify-end">
                        {{ $spaces->links('components.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
