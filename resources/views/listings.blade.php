@extends('layouts.listings.base')

@section('content')
    <section class="-mt-32 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @include('components.forms._filter', ['filters' => $filters])
                </div>
            </div>
        </div>
    </section>

    <section class="pt-12 pb-6">
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
