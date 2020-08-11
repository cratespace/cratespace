@extends('layouts.app.base')

@section('content')
    <section class="py-8">
        <form action="{{ route('spaces.create') }}" method="POST" class="container">
            @csrf

            @include('business.spaces.sections._form', ['space' => $space])
        </form>
    </section>
@endsection
