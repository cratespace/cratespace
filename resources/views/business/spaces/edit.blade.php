@extends('layouts.app.base')

@section('content')
    <section class="py-8">
        <form action="{{ route('spaces.update', $space) }}" method="POST" class="container">
            @csrf

            @method('PUT')

            @include('business.spaces.sections._form', ['space' => $space])
        </form>
    </section>
@endsection

