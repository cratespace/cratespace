<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Note <span class="text-gray-500 font-normal">(Optional)</span></span>

    <textarea name="note" id="note" rows="5" placeholder="Extra information to remember about this space" class="form-input block w-full mt-1 @error('note') is-invalid @enderror">{{ old('note') ?? ($note ?? null) }}</textarea>
</label>

@error('note')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
