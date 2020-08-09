<label for="tax" class="block">
    <span class="text-gray-700 text-sm font-semibold">Tax <span class="text-gray-500 font-normal">(USD)</span></span>

    <input id="tax" class="form-input mt-1 block w-full" placeholder="0.00" name="tax" value="{{ old('tax') ?? ($tax ?? null) }}" />
</label>

@error('tax')
    <div class="mt-1" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
