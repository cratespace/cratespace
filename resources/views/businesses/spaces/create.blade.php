@extends('layouts.app.base')

@section('content')
    <section class="pt-6">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
                        Add Space
                    </h2>

                    <div class="flex items-center text-gray-600">
                        Get closer to your first sale by adding products.
                    </div>

                    <hr class="mt-2 lg:mt-4">
                </div>
            </div>
        </div>
    </section>

    <form class="pt-6 pb-12" action="{{ route('spaces.store') }}" method="POST">
        @csrf

        <div class="container">
            <div class="row mb-6">
                <div class="col-lg-4">
                    <div class="mb-6">
                        <h4 class="text-xl font-semibold">
                            Basic
                        </h4>

                        <p class="text-sm text-gray-600 max-w-sm">
                            The cutomer needs to get a basic understanding of the space you have available, to see if it suits there needs.
                        </p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="shadow rounded-lg overflow-hidden">
                        <div class="bg-white px-4 py-5 sm:px-6">
                            @include('businesses.spaces.components.forms._basic', ['space' => new App\Models\Space])
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    <div class="mb-6">
                        <h4 class="text-xl font-semibold">
                            Shipping
                        </h4>

                        <p class="text-sm text-gray-600 max-w-sm">
                            Please be warned that you are responsible for the accuracy of this information. Please be specific when mentioning origin and destination locations.
                        </p>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="shadow rounded-lg overflow-hidden">
                        <div class="bg-white px-4 py-5 sm:px-6">
                            @include('businesses.spaces.components.forms._shipping', ['space' => new App\Models\Space])
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <hr class="mb-6">

                    <div class="flex items-center justify-end">
                        <button class="btn btn-primary ml-3" type="submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.datetime').flatpickr({
                defaultDate: '{{ now()->addDays(rand(1, 7)) }}',
                dateFormat: 'Y-m-d H:i',
                altInput: true,
                altFormat: 'j M Y, h:i K',
                ariaDateFormat: 'Y-m-d H:i',
                enableTime: true
            });
        });
    </script>
@endpush
