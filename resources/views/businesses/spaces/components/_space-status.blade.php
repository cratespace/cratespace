@php
    switch ($status) {
        case 'Ordered':
            $color = 'indigo';
            break;

        case 'Expired':
            $color = 'red';
            break;

        default:
            $color = 'green';
            break;
    }
@endphp

<span class="relative inline-block px-3 py-1 text-xs font-semibold text-{{ $color }}-900 leading-tight">
    <span aria-hidden="" class="absolute inset-0 bg-{{ $color }}-200 opacity-50 rounded-full"></span>
    <span class="relative">{{ $status }}</span>
</span>
