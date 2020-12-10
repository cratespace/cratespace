@extends('layouts.app')

@section('title')
    <h5 class="text-white font-semibold text-xl leading-none m-0 p-0">
        API Tokens
    </h5>
@endsection

@section('content')
    <api-token-management
        :available-permissions="{{ json_encode($availablePermissions) }}"
        :default-permissions="{{ json_encode($defaultPermissions) }}">
    </api-token-management>
@endsection
