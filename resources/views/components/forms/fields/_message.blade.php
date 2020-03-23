<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Message</span>

    <textarea id="body" name="body" rows="5" class="form-textarea mt-1 block w-full @error('body') placeholder-red-500 border-red-300 bg-red-100 @enderror" placeholder="Tell us what we can help you with.">{{ old('body') }}</textarea>
</label>

@error('body')
    <div class="mt-2" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
