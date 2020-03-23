<label class="block">
    <span class="text-gray-700 text-sm font-semibold">{{ $label ?? 'Email' }}</span>

    <input type="email" name="email" id="email" class="form-input mt-1 block w-full @error('email') placeholder-red-500 border-red-300 bg-red-100 @enderror" placeholder="john.doe@example.com" required value="{{ old('email') ?? ($email ?? null) }}">
</label>

@error('email')
    <div class="mt-2" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
