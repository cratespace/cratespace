<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Country based in') }}</span>

    <input type="text" name="base" id="base" value="{{ old('base') ?? ($base ?? user('business')->country) }}" autocomplete="base" placeholder="Sri Lanka" class="form-input block w-full mt-1 @error('base') is-invalid @enderror">
</label>

@error('base')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror

<span class="text-sm block mt-2 text-gray-500" role="alert">
    The country where this shipping will initiate. Usually where your business is located.
</span>
