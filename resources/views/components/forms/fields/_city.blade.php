<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('City / Region') }}</span>

    <input type="text" name="city" id="city" value="{{ old('city') ?? ($city ?? null) }}" autocomplete="city" placeholder="Colombo" class="form-input block w-full mt-1 @error('city') is-invalid @enderror">
</label>

@error('city')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
