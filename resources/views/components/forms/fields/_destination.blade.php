<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Destination') }}</span>

    <input type="text" name="destination" id="destination" value="{{ old('destination') ?? ($destination ?? null) }}" autocomplete="destination" placeholder="Benton, Arkansas" class="form-input block w-full mt-1 @error('destination') is-invalid @enderror">
</label>

@error('destination')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
