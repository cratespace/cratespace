@props(['hasHeader' => false, 'hasFooter' => false, 'bgColor' => 'bg-white', 'shadow' => 'shadow'])

<div class="overflow-hidden rounded-lg {{ $shadow }} flex flex-col flex-1">
    @if ($hasHeader)
        <div class="{{ $bgColor }} px-4 py-5 sm:px-6 flex flex-col flex-1">
            {{ $title }}
        </div>
    @endif

    <div class="{{ $bgColor }} px-4 py-5 sm:px-6 flex flex-col flex-1">
        {{ $slot }}
    </div>

    @if ($hasFooter)
        {{ $footer }}
    @endif
</div>
