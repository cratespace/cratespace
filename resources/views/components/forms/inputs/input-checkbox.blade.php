@props(['name' => null, 'id' => null, 'label' => null])

<label for="{{ $name }}" class="flex items-center cursor-pointer">
    <input {{ $attributes->merge(['class' => 'form-checkbox rounded text-blue-500 bg-white border border-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out']) }} id="{{ $id ?? $name }}" name="{{ $name }}" type="checkbox"/>


    <span class="ml-2 text-sm font-medium leading-5">{{ $label }}</span>
</label>

