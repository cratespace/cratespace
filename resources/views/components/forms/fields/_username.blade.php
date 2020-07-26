<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Username</span>

    <input name="username" id="username" type="text" class="form-input mt-1 block w-full @error('username') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('username') ?? ($username ?? null) }}" placeholder="JohnDoe">
</label>

@error('username')
    <div class="mt-2" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
