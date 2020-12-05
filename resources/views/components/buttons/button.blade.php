<button {{ $attributes->merge(['class' => 'inline-block items-center whitespace-no-wrap px-4 py-0 leading-9 border border-transparent rounded-xl  focus:outline-none focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150']) }}>
    <span class="font-medium text-sm">{{ $slot }}</span>
</button>
