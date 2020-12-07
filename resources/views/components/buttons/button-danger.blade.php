<x-buttons.button {{ $attributes->merge(['class' => 'text-white hover:text-white focus:text-white active:text-white bg-red-500 hover:bg-red-600 focus:bg-red-600 active:bg-red-600']) }}>
    {{ $slot }}
</x-buttons.button>
