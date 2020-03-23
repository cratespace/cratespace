<div class="row">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4 class="text-xl font-semibold">
                Security
            </h4>

            <p class="text-sm text-gray-600 max-w-sm">
                Take care while you handle these settings. These actions will cause permanent loss of data.
            </p>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="shadow rounded-lg overflow-hidden">
            <div class="bg-white px-4 py-5 sm:px-6">
                <h5 class="text-lg font-medium text-gray-800 mb-3">
                    Delete your account
                </h5>

                <p class="text-gray-600 mb-6">
                    Once you delete your account, you will lose all data associated with it.
                </p>

                <button class="btn bg-red-200 text-red-800" type="button" data-toggle="modal" data-target="#deleteModal{{ $user->username }}">Delete account</button>
            </div>
        </div>
    </div>
</div>
