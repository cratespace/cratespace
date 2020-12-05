@props(['menuDirection' => 'normal', 'button' => null, 'linkAttributes' => null])

<x-dropdowns.dropdown {{ $attributes }} menuDirection="{{ $menuDirection }}" button="{{ $button }}">
    <x-slot name="trigger">
        <a href="#" class="dropdown-toggle text-gray-400 hover:text-white focus:text-white active:text-white flex-no-shrink block focus:outline-none transition ease-in-out duration-150 {{ $linkAttributes }}" data-toggle="dropdown" aria-expanded="false" role="button">
            {{ $trigger }}
        </a>
    </x-slot>

    <x-slot name="links">
        {{ $links }}
    </x-slot>
</x-dropdowns.dropdown>
