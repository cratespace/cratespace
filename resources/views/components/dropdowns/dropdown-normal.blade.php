@props(['menuDirection' => 'normal', 'button' => null, 'linkAttributes' => null])

<x-dropdowns.dropdown {{ $attributes }} menuDirection="{{ $menuDirection }}" button="{{ $button }}">
    <x-slot name="trigger">
        <a href="#" class="flex-no-shrink block dropdown-toggle focus:outline-none transition ease-in-out duration-150 {{ $linkAttributes }}" data-toggle="dropdown" aria-expanded="false" role="button">
            {{ $trigger }}
        </a>
    </x-slot>

    <x-slot name="links">
        {{ $links }}
    </x-slot>
</x-dropdowns.dropdown>
