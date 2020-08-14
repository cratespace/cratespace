<label for="price" class="block">
    <span class="text-gray-700 text-sm font-semibold">Price <span class="text-gray-500 font-normal">(USD)</span></span>

    <input id="price" class="form-input mt-1 block w-full" required placeholder="0.00" name="price" value="{{ old('price') ?? ($price ?? null) }}" />
</label>

@error('price')
    <div class="mt-1" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
