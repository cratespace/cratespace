<a {{ $attributes->merge(['class' => 'px-4 py-0 leading-9 rounded-xl opacity-75 hover:opacity-100 bg-transparent hover:bg-gray-900 hover:bg-opacity-50 focus:bg-gray-900 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150 ml-4']) }}>
    <span class="font-semibold text-sm">{{ $slot }}</span>
</a>
