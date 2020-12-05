@props(['name' => null, 'id' => null, 'label' => null, 'value' => null, 'instruction' => false, 'type' => 'text'])

<label class="block" for="{{ $id ?? $name }}">
    <span class="block text-gray-600 text-sm font-semibold">{{ ucfirst($label ?? $name) }}</span>

    <input {{ $attributes->merge(['class' => 'mt-1 block w-full rounded-lg shadow-sm bg-white border border-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 placeholder-gray-400 transition ease-in-out duration-150']) }} type="{{ $type }}" name="{{ $name }}" id="{{ $id ?? $name }}" value="{{ old($name, ($value ?: null)) }}">
</label>

@if ($instruction)
    <div class="mt-1">
        <span class="font-medium text-xs text-gray-500">{{ $instruction }}</span>
    </div>
@endif

@error($name)
    <div class="mt-1">
        <span class="font-medium text-xs text-red-500">{{ $message }}</span>
    </div>
@enderror
