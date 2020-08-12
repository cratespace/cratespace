@extends('layouts.web.base', ['bgColor' => 'bg-gray-200'])

@section('content')
    <section class="py-16">
        <div class="container">
            <div class="row justify-center">
                <div class="col-md-5">
                    <div class="text-center text-green-500">
                        @if (session('status'))
                            <h2>{{ session('status') }}</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
