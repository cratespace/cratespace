<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Password</span>

    <input type="password" name="password" id="password" class="form-input mt-1 block w-full @error('password') placeholder-red-500 border-red-300 bg-red-100 @enderror" autocomplete="new-password" placeholder="doyourememberme" required>
</label>

@error('password')
    <div class="mt-2" role="alert">
        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
    </div>
@enderror
