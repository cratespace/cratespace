@extends('layouts.web.base')

@section('content')
    <section class="-mt-16 h-screen flex justify-center items-center">
        <div class="container">
            <div class="row justify-center">
                <div class="col-4">
                    <hashids-input code="{{ old('code', ($code ?? null)) }}"></hasids-input>
                </div>
            </div>
        </div>
    </section>
@endsection
