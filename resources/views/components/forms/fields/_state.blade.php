<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('State/Province') }}</span>

    <input type="text" name="state" id="state" value="{{ old('state') ?? ($state ?? null) }}" autocomplete="state" placeholder="Western" class="form-input block w-full mt-1 @error('state') is-invalid @enderror">
</label>

@error('state')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
