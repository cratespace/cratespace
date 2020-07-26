
<div>
    <label for="phone" class="block">
        <span class="text-gray-700 text-sm font-semibold">{{ $label ?? 'Phone' }}</span>
    </label>

    <div class="mt-1 relative rounded-lg shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                <span class="text-gray-500">
                    +94
                </span>
            </div>

        <input id="phone" name="phone" type="tel" class="form-input block w-full px-12 @error('phone') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('phone') ?? ($phone ?? null) }}" placeholder="76 589 5534" />
    </div>
</div>

@error('phone')
    <div class="mt-2" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
