<div class="row">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4>
                Profile
            </h4>

            <p class="text-sm max-w-sm">
                This information except your email and phone number will be displayed publicly so be careful what you share.
            </p>
        </div>
    </div>

    <div class="col-lg-7 offset-lg-1">
        <profile :user="{{ $user }}" route="{{ route('users.update', $user) }}"></profile>
    </div>
</div>
