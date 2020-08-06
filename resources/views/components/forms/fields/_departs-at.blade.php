<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Departure date & time') }}</span>

    <input type="text" name="departs_at" id="departs_at" value="{{ old('departs_at') ?? ($departs_at ?? null) }}" data-default-date="{{ $departs_at ? $departs_at->toDateTimeString() : null }}" required placeholder="Departure date" autocomplete="departs_at" class="datetime form-input block w-full mt-1 @error('departs_at') is-invalid @enderror">
</label>

@error('departs_at')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
