<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Departure date & time') }}</span>

    <input type="text" name="departsAt" id="departsAt" value="{{ old('departsAt') ?? ($departsAt ?? null) }}" required placeholder="Departure date" autocomplete="departsAt" class="datetime form-input block w-full mt-1 @error('departsAt') is-invalid @enderror">
</label>

@error('departsAt')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
