<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Country') }}</span>

    <input type="text" name="country" id="country" value="{{ old('country') ?? ($country ?? 'Sri Lanka') }}" autocomplete="country" placeholder="Sri Lanka" class="form-input block w-full mt-1 @error('country') is-invalid @enderror">
</label>

@error('country')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
