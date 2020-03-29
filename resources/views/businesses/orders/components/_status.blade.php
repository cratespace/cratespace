@php
    switch($status) {
        case('Confirmed'):
            $color = 'blue';
            break;

        case('Completed'):
            $color = 'green';
            break;

        case('Canceled'):
            $color = 'red';
            break;

        default:
            $color = 'yellow';
    }
@endphp

<span class="relative inline-block px-3 py-1 font-semibold {{ 'text-' . $color . '-800' }} leading-tight">
    <span aria-hidden="true" class="absolute inset-0 {{ 'bg-' . $color . '-200'}} opacity-50 rounded-full"></span>
    <span class="relative">{{ $status }}</span>
</span>
