@extends('layouts.app')

@section('content')
    <section class="pt-6 pb-12">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="bg-white shadow overflow-hidden rounded-lg">
                        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800 uppercase">
                                        {{ '#' . $space->uid }}
                                    </h3>

                                    <div class="mt-1">
                                        <span class="mr-1 relative inline-block px-3 py-1 text-xs font-semibold text-indigo-900 leading-tight">
                                            <span aria-hidden="" class="absolute inset-0 bg-indigo-200 opacity-50 rounded-full"></span>
                                            <span class="relative">{{ $space->type }}</span>
                                        </span>

                                        @include('businesses.spaces.components._space-status', ['status' => $space->status])
                                    </div>
                                </div>

                                <div class="flex">
                                    <a role="button" href="{{ route('spaces.edit', $space) }}" class="btn shadow-none p-2 inline-block ml-1">
                                        <svg class="h-5 w-5 hover:text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </a>

                                    <button class="ml-2 btn shadow-none p-2 inline-block" data-toggle="modal" data-target="#deleteModal{{ $space->uid }}">
                                        <svg class="h-5 w-5 hover:text-gray-700" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <dl>
                                <div class="bg-gray-100 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-600">
                                        Dimensions
                                    </dt>

                                    <dd class="mt-1 text-sm leading-snug text-gray-800 sm:mt-0 sm:col-span-2">
                                        <div class="flex text-xl">
                                            <div class="mr-3">
                                                <div>
                                                    {{ $space->height }} <span class="text-sm text-gray-600">Ft</span>
                                                </div>

                                                <div class="text-xs text-gray-600">Height</div>
                                            </div>

                                            <div class="mr-3">
                                                <div>
                                                    {{ $space->width }} <span class="text-sm text-gray-600">Ft</span>
                                                </div>

                                                <div class="text-xs text-gray-600">Width</div>
                                            </div>

                                            <div>
                                                <div>
                                                    {{ $space->length }} <span class="text-sm text-gray-600">Ft</span>
                                                </div>

                                                <div class="text-xs text-gray-600">Length</div>
                                            </div>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-snug font-medium text-gray-600">
                                Maximum allowable weight
                            </dt>

                            <dd class="mt-1 text-sm leading-snug text-gray-800 sm:mt-0 sm:col-span-2">
                                <div class="text-xl">
                                    {{ $space->weight }} <span class="text-sm text-gray-600">Kg</span>
                                </div>
                            </dd>
                        </div>

                        <div class="bg-gray-100 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-snug font-medium text-gray-600">
                                Origin
                            </dt>

                            <dd class="mt-1 text-sm leading-snug text-gray-800 sm:mt-0 sm:col-span-2">
                                {{ $space->origin }}
                            </dd>
                        </div>

                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-snug font-medium text-gray-600">
                                Destination
                            </dt>

                            <dd class="mt-1 text-sm leading-snug text-gray-800 sm:mt-0 sm:col-span-2">
                                {{ $space->destination }}
                            </dd>
                        </div>

                        <div class="bg-gray-100 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-snug font-medium text-gray-600">
                                Date of departure
                            </dt>

                            <dd class="mt-1 text-sm leading-snug text-gray-800 sm:mt-0 sm:col-span-2">
                                <div>
                                    <div class="text-indigo-500 font-medium">{{ $space->departs_at->format('M jS, g:i a') }}</div>
                                </div>

                                <div class="text-xs text-gray-600">
                                    {{ $space->departs_at->diffForHumans() }}
                                </div>
                            </dd>
                        </div>

                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-snug font-medium text-gray-600">
                                Date of arrival at port
                            </dt>

                            <dd class="mt-1 text-sm leading-snug text-gray-800 sm:mt-0 sm:col-span-2">
                                <div>
                                    <div class="text-indigo-500 font-medium">{{ $space->arrives_at->format('M jS, g:i a') }}</div>
                                </div>

                                <div class="text-xs text-gray-600">
                                    {{ $space->arrives_at->diffForHumans() }}
                                </div>
                            </dd>
                        </div>

                        <div class="bg-gray-100 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-snug font-medium text-gray-500">
                                Note
                            </dt>

                            <dd class="mt-1 text-sm leading-snug text-gray-800 sm:mt-0 sm:col-span-2">
                                {{ $space->note ?? 'No note added' }}
                            </dd>
                        </div>

                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm leading-snug font-medium text-gray-500">
                                Price
                            </dt>

                            <dd class="mt-1 sm:mt-0 sm:col-span-2">
                                <span class="text-2xl leading-none">
                                    {{ '$' . $space->price }} <span class="text-xs text-gray-600 font-medium">USD</span>
                                </span>
                            </dd>
                        </div>
                    </div>
                </div>

                @if ($order)
                    <div class="col-lg-4 mt-6 lg:mt-0">
                        <order-details :data="{{ $order }}"></order-details>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    @include('businesses.spaces.components.modals._delete-confirmation', ['space' => $space])
@endsection
