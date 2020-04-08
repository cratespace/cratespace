@extends('support.threads.layouts.base')

@section('body')
    <div class="mb-8">
        <div class="mb-10">
            <span class="text-3xl text-gray-800">Start new discussion</span>
        </div>

        <div class="mb-20 leading-relaxed markdown">
            <form action="{{ route('support.threads.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label>
                        <span class="text-gray-700 text-sm font-semibold block">{{ __('Channel') }}</span>

                        <select class="form-select mt-1 bg-white shadow">
                            @forelse ($channels as $channel)
                                <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                            @empty
                                <option>Choose channel</option>
                            @endforelse
                        </select>
                    </label>
                </div>

                <div class="mb-10">
                    <label class="block">
                        <span class="text-gray-700 text-sm font-semibold">What's your question?</span>

                        <input name="title" id="title" type="text" class="form-input bg-white mt-1 block w-full @error('title') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('title') ?? ($title ?? null) }}" placeholder="Where is Waldo?">
                    </label>

                    @error('title')
                        <div class="mt-2" role="alert">
                            <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="mb-10">
                    <div class="text-gray-700 text-sm font-semibold mb-4">Before you email, do these answer your question?</div>

                    <div>
                        @forelse ($threads as $thread)
                            @include('support.threads.components._thread', ['thread' => $thread])
                        @empty
                            <span class="text-gray-500">No threads found.</span>
                        @endforelse
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block">
                        <span class="text-gray-700 text-sm font-semibold">Tell us more</span>

                        <textarea name="body" id="body" rows="5" placeholder="Extra information to help us understand your problem" class="form-input block bg-white w-full mt-1 @error('body') is-invalid @enderror">{{ old('body') ?? ($body ?? null) }}</textarea>
                    </label>

                    @error('body')
                        <span class="text-sm block mt-2 text-red-500" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <hr class="mb-6">

                <div>
                    <button type="submit" class="btn btn-primary">Post discussion</button>
                </div>
            </form>
        </div>
    </div>
@endsection
