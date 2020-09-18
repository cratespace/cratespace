<label class="block">
    <span class="text-gray-700 text-sm font-semibold">Password</span>

    <input type="password" name="password_confirmation" id="password-confirm" minlength="8" pattern="^(?+.\d)(?=.[a-z])(?=.*[A-Z]).{8,}$" class="form-input mt-1 block w-full @error('password') placeholder-red-500 border-red-300 bg-red-100 @enderror" autocomplete="new-password" placeholder="iwillalsobeforgetful" required>
</label>
