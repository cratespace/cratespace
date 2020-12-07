@props(['action' => null, 'method' => 'POST'])

<form {{ $attributes }} action="{{ $action }}" method="{{ $method === 'GET' ? 'GET' : 'POST' }}" enctype="multipart/form-data" accept-charset="utf-8">
    @if (! in_array($method, ['GET', 'POST']))
        @method($method)
    @endif

    @csrf

    <div>
        {{ $slot }}
    </div>
</form>
