<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Full name</span>

    <input name="name" id="name" type="text" class="form-input mt-1 block w-full @error('name') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('name') ?? ($name ?? null) }}" placeholder="John Doe">
</label>

@error('name')
    <div class="mt-2" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
