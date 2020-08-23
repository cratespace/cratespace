@extends('layouts.web.base')

@section('content')
    <section class="pt-8 pb-16 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div>
                        <div>
                            <h3 class="leadin-snug">
                                {{ $ticket->subject }}
                            </h3>

                            <div>
                                <h6>Ticket code: <span class="text-blue-500">{{ $ticket->code }}</span></h6>
                            </div>
                        </div>

                        <div class="mt-10 flex items-start">
                            <div class="flex-no-shrink h-12 w-12">
                                <a class="bg-blue-200 shadow-none px-0 h-12 w-12 flex items-center justify-center rounded-full overflow-hidden dropdown-toggle" href="#">
                                    <img class="h-12 w-12" src="{{ asset('img/default.jpg') }}">
                                </a>
                            </div>

                            <div class="ml-6 text-lg text-gray-700">
                                <div>
                                    <h6 class="font-semibold text-gray-800 text-base">{{ $ticket->customer->name }}</h6>

                                    <span class="text-sm text-gray-500">{{ $ticket->updated_at->diffForHumans() }}</span>
                                </div>

                                <div class="mt-2 prose">
                                    {{ $ticket->description }}
                                </div>

                                <div class="mt-4 flex items-center">
                                    <a class="text-sm" href="#" role="button" data-toggle="modal" data-target="#threadModal">Edit</a>

                                    <a class="ml-6 text-sm" href="/">Delete</a>
                                </div>
                            </div>
                        </div>

                        @guest
                            <div class="mt-10">
                                <div class="flex-1 ml-6 text-lg text-gray-700">
                                    <form class="w-full" action="{{ route('replies.store', ['ticket' => $ticket]) }}" method="POST">
                                        @csrf

                                        <div>
                                            <textarea id="body" name="body" class="form-textarea block w-full" rows="3" placeholder="Type here to reply to thread"></textarea>
                                        </div>

                                        <div class="mt-6">
                                            <button class="btn btn-primary leading-8">Post reply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endguest

                        <div class="my-20">
                            <div>
                                @forelse ($ticket->replies as $reply)
                                    <div class="mb-6 flex items-start">
                                        <div class="flex-no-shrink h-8 w-8">
                                            <a class="bg-blue-200 shadow-none px-0 h-8 w-8 flex items-center justify-center rounded-full overflow-hidden dropdown-toggle" href="#">
                                                <img class="h-8 w-8" src="{{ $reply->agent->image ?? asset('img/default.jpg') }}">
                                            </a>
                                        </div>

                                        <div class="ml-6 text-gray-700">
                                            <div class="mt-1 leading-none">
                                                <h6 class="font-semibold text-gray-800">{{ $reply->agent->name }}</h6>
                                            </div>

                                            <div class="mt-4 text-sm leading-relaxed">
                                                {{ $reply->body }}
                                            </div>

                                            <div class="mt-4 flex items-center">
                                                <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>

                                                @can('update', $reply)
                                                    <a class="ml-4 text-xs text-gray-500" href="#" role="button" data-toggle="modal" data-target="#replyModal">Edit</a>

                                                    <a class="ml-4 text-xs text-gray-500" href="{{ route('replies.destroy', ['ticket' => $ticket, 'reply' => $reply]) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $reply->id }}').submit();">
                                                        Delete
                                                    </a>

                                                    <form id="delete-form-{{ $reply->id }}" action="{{ route('replies.destroy', ['ticket' => $ticket, 'reply' => $reply]) }}" method="POST" style="display: none;">
                                                        @csrf

                                                        @method('DELETE')
                                                    </form>
                                                @endcan

                                                @auth
                                                    <a class="ml-4 text-xs text-gray-500" href="/">3 Likes</a>

                                                    <a class="ml-4 text-xs text-gray-500" href="/">Reply</a>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
                                        <div class="modal-dialog rounded-lg overflow-hidden">
                                            <form class="modal-content" action="{{ route('replies.update', ['thread' => $thread, 'reply' => $reply]) }}" method="POST">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="replyModalLabel">Reply to <span class="font-semibold text-blue-500">conversation</span></h5>

                                                    <button type="button" class="close font-normal" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    @csrf

                                                    @method('PUT')

                                                    <textarea id="body" name="body" class="form-textarea block w-full" rows="10" placeholder="Type here to reply to thread">{{ $reply->body }}</textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                                                    <button type="submit" class="ml-4 btn btn-primary">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div>
                                        <div class="overflow-hidden rounded-lg border-2 border-dotted">
                                            <div class="px-4 py-5 sm:px-6 text-center">
                                                <div class="text-sm">Thread has replies yet.</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <hr class="my-10">

                        <div>
                            <div>
                                <h5>Related articles</h5>
                            </div>

                            <div class="mt-6">
                                <div class="mb-8">
                                    <a href="#" class="block">
                                        <h6 class="text-base">Cras mattis consectetur purus sit amet fermentum</h6>
                                    </a>

                                    <p class="text-sm mt-2">
                                        Donec id elit non mi porta gravida at eget metus. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    </p>
                                </div>

                                <div class="mb-8">
                                    <a href="#" class="block">
                                        <h6 class="text-base">Maecenas faucibus mollis interdum</h6>
                                    </a>

                                    <p class="text-sm mt-2">
                                        Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 offset-md-1 col-lg-3 offset-lg-2">
                    @include('support.partials._sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
