<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Street address') }}</span>

    <input type="text" name="street" id="street" value="{{ old('street') ?? ($street ?? null) }}" autocomplete="street" placeholder="21 Manning Place" class="form-input block w-full mt-1 @error('street') is-invalid @enderror">
</label>

@error('street')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
