@props(['hasHeader' => false, 'hasFooter' => false])

<div class="overflow-hidden rounded-lg shadow flex flex-col flex-1">
    @if ($hasHeader)
        <div class="bg-white px-4 py-5 sm:px-6 flex flex-col flex-1">
            {{ $title }}
        </div>
    @endif

    <div class="bg-white px-4 py-5 sm:px-6 flex flex-col flex-1">
        {{ $slot }}
    </div>

    @if ($hasFooter)
        {{ $footer }}
    @endif
</div>
