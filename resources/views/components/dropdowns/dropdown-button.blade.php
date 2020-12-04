@props(['menuDirection' => 'normal', 'button' => 'primary'])

<x-dropdowns.dropdown {{ $attributes }} menuDirection="{{ $menuDirection }}" button="{{ $button }}">
    <x-slot name="trigger">
        @switch($button)
            @case('primary')
                <x-buttons.button-primary class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">
                    {{ $trigger }}
                </x-buttons.button-primary>
                @break

            @case('secondary')
                <x-buttons.button-secondary class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">
                    {{ $trigger }}
                </x-buttons.button-secondary>
                @break

            @case('danger')
                <x-buttons.button-danger class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">
                    {{ $trigger }}
                </x-buttons.button-danger>
                @break
        @endswitch
    </x-slot>

    <x-slot name="links">
        {{ $links }}
    </x-slot>
</x-dropdowns.dropdown>


