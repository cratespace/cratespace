<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Bussiness name</span>

    <input type="text" name="business" id="business" class="form-input mt-1 block w-full @error('business') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('business') ?? ($business ?? null) }}" placeholder="Example Company">
</label>

@error('business')
    <div class="mt-2" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
