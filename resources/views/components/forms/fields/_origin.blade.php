<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Place of origin') }}</span>

    <input type="text" name="origin" id="origin" value="{{ old('origin') ?? ($origin ?? null) }}" autocomplete="origin" placeholder="Clanton, Alabama" class="form-input block w-full mt-1 @error('origin') is-invalid @enderror">
</label>

@error('origin')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
