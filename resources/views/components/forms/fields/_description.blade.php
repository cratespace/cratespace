<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ __('Description') }}</span>

    <textarea name="description" id="description" rows="5" placeholder="Tell us a little about your business" class="form-input block w-full mt-1 @error('description') is-invalid @enderror">{{ old('description') ?? ($description ?? null) }}</textarea>
</label>

@error('description')
    <span class="text-sm block mt-2 text-red-500" role="alert">
        {{ $message }}
    </span>
@enderror
