<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Maximum allowable weight <span class="text-gray-500 font-normal">(Kg)</span></span>

        <input type="number" name="weight" id="weight" min="0" class="form-input mt-1 block w-full @error('weight') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('weight') ?? ($weight ?? null) }}">
</label>

@error('weight')
    <div class="mt-1" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
