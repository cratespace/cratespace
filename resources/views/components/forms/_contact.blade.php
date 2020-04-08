<form action="{{ route('messages.store') }}" method="POST">
    <div class="mb-6">
        @include('components.forms.fields._name')
    </div>

    <div class="row">
        <div class="col-md-6 mb-6">
            @include('components.forms.fields._phone')
        </div>

        <div class="col-md-6 mb-6">
            @include('components.forms.fields._email')
        </div>
    </div>

    <div class="mb-6">
        @include('components.forms.fields._subject')
    </div>

    <div class="mb-6">
        @include('components.forms.fields._message')
    </div>

    <div>
        <div class="flex justify-end items-center">
            <button class="btn btn-primary w-full">Let's talk</button>
        </div>
    </div>
</form>
