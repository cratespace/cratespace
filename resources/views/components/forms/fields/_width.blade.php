<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Width (Ft)</span>

        <input type="number" name="width" id="width" min="0" class="form-input mt-1 block w-full @error('width') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('width') ?? ($width ?? null) }}">
</label>

@error('width')
    <div class="mt-1" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
