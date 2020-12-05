<a {{ $attributes->merge(['class' => 'dropdown-item leading-6 rounded-lg block text-gray-600 hover:text-gray-600 focus:text-white active:text-white hover:bg-gray-100 focus:bg-blue-500 active:bg-blue-600 focus:outline-none transition ease-in-out duration-150']) }}>
    <span class="font-semibold text-sm">{{ $slot }}</span>
</a>
