<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Unique Identification Code</span>

        <input type="text" name="uid" id="uid" class="form-input mt-1 block w-full @error('uid') placeholder-red-500 border-red-300 bg-red-100 @enderror" placeholder="WA52M" required value="{{ old('uid') ?? ($uid ?? null) }}">
</label>

@error('uid')
    <div class="mt-1" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
