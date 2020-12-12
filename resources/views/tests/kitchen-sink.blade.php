@extends('layouts.public')

@section('content')
    <section-content class="min-h-screen h-screen bg-gray-700">
        <div class="row justify-center py-16">
            <div class="col-12 col-md-8 col-lg-6">
                <card :hasActions="false">
                    <template #content>
                        Hello
                    </template>
                </card>
            </div>
        </div>
    </section-content>
@endsection
