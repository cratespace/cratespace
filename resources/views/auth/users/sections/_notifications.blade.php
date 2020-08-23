<div class="row">
    <div class="col-lg-4">
        <div class="mb-6">
            <h4>
                Notifications
            </h4>

            <p class="text-sm max-w-sm">
                We'll always let you know about important changes, but you pick what else you want to hear about.
            </p>
        </div>
    </div>

    <div class="col-lg-7 offset-lg-1">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            <div>
                {{--  --}}

                <div class="mt-6 py-3 flex items-center justify-end">
                    <button class="btn btn-primary ml-3" type="submit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
