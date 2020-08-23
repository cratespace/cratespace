@extends('layouts.web.base')

@section('content')
    <section class="pt-8 pb-16 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div>
                        <h3 class="leadin-snug">
                            How can we help?
                        </h3>

                        <div class="mt-6">
                            <form>
                                <label class="block relative">
                                    <input name="search" id="search" type="text" class="form-input mt-1 block w-full pl-10 @error('search') placeholder-red-500 border-red-300 bg-red-100 @enderror" required value="{{ old('search') ?? ($search ?? null) }}" placeholder="Search help articles...">

                                    <div class="absolute top-0 left-0 bottom-0 flex items-center justify-center px-3">
                                        <x:heroicon-o-search class="w-4 h-4"/>
                                    </div>
                                </label>

                                @error('search')
                                    <div class="mt-2" role="alert">
                                        <span class="text-xs text-red-500 font-semibold">{{ $message }}</span>
                                    </div>
                                @enderror
                            </form>
                        </div>

                        <hr class="my-10">

                        <div>
                            <div>
                                <h5>Recommended articles</h5>
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
