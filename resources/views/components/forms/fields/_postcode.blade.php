<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Postcode') }}</span>

    <input type="text" name="postcode" id="postcode" value="{{ old('postcode') ?? ($postcode ?? null) }}" required autocomplete="postcode" placeholder="70000" class="form-input block w-full mt-1 @error('postcode') is-invalid @enderror">
</label>

@error('postcode')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
