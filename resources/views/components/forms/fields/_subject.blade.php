<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Subject</span>

    <input name="subject" id="subject" type="text" class="form-input mt-1 block w-full @error('subject') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('subject') }}" placeholder="Business Inquiry">
</label>

@error('subject')
    <div class="mt-2" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
