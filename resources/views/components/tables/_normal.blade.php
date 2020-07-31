<div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
    <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
        <table class="min-w-full">
            <thead>
                <tr>
                    {{ $head }}
                </tr>
            </thead>

            <tbody class="bg-white">
                {{ $body }}
            </tbody>
        </table>

        <div class="py-2 sm:px-6 bg-gray-100">
            {{ $pagination }}
        </div>
    </div>
</div>
