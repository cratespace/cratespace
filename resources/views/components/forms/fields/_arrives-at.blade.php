<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Arrival date & time') }}</span>

    <input type="text" name="arrivesAt" id="arrivesAt" value="{{ old('arrivesAt') ?? ($arrivesAt ?? null) }}" required placeholder="Arrival date" autocomplete="arrivesAt" class="datetime form-input block w-full mt-1 @error('arrivesAt') is-invalid @enderror">
</label>

@error('arrivesAt')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
