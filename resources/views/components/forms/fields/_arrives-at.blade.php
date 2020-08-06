<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Arrival date & time') }}</span>

    <input type="text" name="arrives_at" id="arrives_at" value="{{ old('arrives_at') ?? ($arrives_at ?? null) }}" data-default-date="{{ $arrives_at ? $arrives_at->toDateTimeString() : null }}" required placeholder="Arrival date" autocomplete="arrives_at" class="datetime form-input block w-full mt-1 @error('arrives_at') is-invalid @enderror">
</label>

@error('arrives_at')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
