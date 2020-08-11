<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Height <span class="text-gray-500 font-normal">(Ft)</span></span>

        <input type="number" name="height" id="height" min="0" class="form-input mt-1 block w-full @error('height') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('height') ?? ($height ?? null) }}">
</label>

@error('height')
    <div class="mt-1" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
