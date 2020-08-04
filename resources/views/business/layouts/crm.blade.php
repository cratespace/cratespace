@extends('layouts.app.base')

@section('content')
    <section class="py-8">
        <div class="container">
            <div class="row items-center">
                <div class="col-lg-4 col-md-6">
                    <div>
                        <h4>
                            {{ $pageTitle }}
                        </h4>

                        <p class="text-sm max-w-sm">
                            Showing a total of {{ $resource->total() }} resource
                        </p>
                    </div>
                </div>

                <div class="mt-4 md:mt-0 col-lg-5 offset-lg-3 col-md-6">
                    <div class="flex justify-end items-center">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-sm">Show: <span class="font-bold text-gray-800">{{ request('status') ?? 'All' }}</span></span>
                            </button>

                            <div class="mt-3 dropdown-menu dropdown-menu-right rounded-lg shadow-lg" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item text-sm font-medium text-gray-600 focus:text-white active:text-white py-2 @if (request('status') === null) active hover:text-white @else hover:text-gray-700 @endif" href="{{ route($resourceName . '.index') }}">All</a>

                                @foreach ($statuses as $status)
                                    <a class="dropdown-item text-sm font-medium text-gray-600 focus:text-white active:text-white py-2 @if (request('status') === $status) active hover:text-white @else hover:text-gray-700 @endif" href="{{ route($resourceName . '.index', ['status' => $status]) }}">{{ $status }}</a>
                                @endforeach
                            </div>
                        </div>

                        <form class="ml-4 w-80 relative" action="{{ route($resourceName . '.index') }}" method="GET">
                            <input type="text" name="search" id="search" class="pl-10 form-input w-full block bg-white" placeholder="Search..." value="{{ old('search', request('search')) }}" required autocomplete="search">

                            <div class="absolute top-0 left-0 bottom-0 flex items-center px-3">
                                <x:heroicon-o-search class="w-5 h-5 text-gray-600"/>
                            </div>

                            <div class="absolute top-0 right-0 bottom-0 flex items-center px-3">
                                <a href="{{ route($resourceName . '.index') }}" class="hover:opacity-100 opacity-50">
                                    <x:heroicon-o-x-circle class="w-5 h-5 text-gray-600"/>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <hr class="my-6">

            <div class="row">
                <div class="col-12">
                    @yield('crm-content')
                </div>
            </div>
        </div>
    </section>
@endsection
