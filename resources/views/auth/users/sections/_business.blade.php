<div class="row">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4>
                Business
            </h4>

            <p class="text-sm max-w-sm">
                This information helps customers recognize your business and understand your terms of service. Your support information may be visible in payment statements, invoices, and receipts.
            </p>
        </div>
    </div>

    <div class="col-lg-7 offset-lg-1">
        <business :business="{{ $user->business }}" route="{{ route('users.business', $user) }}"></business>
    </div>
</div>
