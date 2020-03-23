@extends('layouts.web')

@section('content')
    <section class="pt-12 bg-gray-800" style="padding-bottom: 28rem;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="lg:text-center">
                        <p class="text-base text-gray-300 font-semibold tracking-wide uppercase">Pricing</p>

                        <h3 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                            The right price for you, whoever you are
                        </h3>

                        <p class="max-w-2xl text-xl text-gray-300 lg:mx-auto">
                            Lorem ipsum dolor sit amet consect adipisicing elit. Possimus magnam voluptatum cupiditate veritatis in accusamus quisquam.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-200 pt-12 pb-6">
        <div class="container" style="margin-top: -28rem;">
            <div class="row justify-center">
                <div class="col-lg-5 col-md-6 flex felx-col mb-6">
                    <div class="rounded-lg overflow-hidden shadow-lg flex flex-col flex-1">
                        <div class="bg-white px-10 pt-10 pb-6">
                            <div>
                                <div>
                                    <span class="relative inline-block px-4 py-1 font-semibold text-indigo-600 text-sm leading-normal uppercase">
                                        <span aria-hidden="" class="absolute inset-0 bg-indigo-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Standard</span>
                                    </span>
                                </div>

                                <div class="mt-1">
                                    <span class="text-6xl text-gray-800 font-bold">$49</span> <span class="text-gray-500 font-medium text-2xl">/mo</span>
                                </div>

                                <div class="mt-2">
                                    <p class="leading-relaxed text-lg text-gray-500 lg:max-w-sm">
                                        Nihil hic munitissimus habendi senatus locus, nihil horum.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-100 px-10 pb-10 pt-6 flex flex-col flex-1 justify-between">
                            <p>
                                Nihil hic munitissimus habendi senatus locus, nihil horum? Gallia est omnis divisa in partes tres, quarum. Pellentesque habitant morbi tristique senectus et netus. Tityre, tu patulae recubans sub tegmine fagi dolor. Salutantibus vitae elit libero, a pharetra augue. Magna pars studiorum, prodita quaerimus.
                            </p>

                            <div class="mt-6">
                                <button class="btn btn-primary w-full text-lg">Get started</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-6 flex felx-col mb-6">
                    <div class="rounded-lg overflow-hidden shadow-lg flex flex-col flex-1">
                        <div class="bg-white px-10 pt-10 pb-6">
                            <div>
                                <div>
                                    <span class="relative inline-block px-4 py-1 font-semibold text-indigo-600 text-sm leading-normal uppercase">
                                        <span aria-hidden="" class="absolute inset-0 bg-indigo-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Enterprice</span>
                                    </span>
                                </div>

                                <div class="mt-1">
                                    <span class="text-6xl text-gray-800 font-bold">$79</span> <span class="text-gray-500 font-medium text-2xl">/mo</span>
                                </div>

                                <div class="mt-2">
                                    <p class="leading-relaxed text-lg text-gray-500 lg:max-w-sm">
                                        Vivamus sagittis lacus vel augue laoreet rutrum faucibus.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-100 px-10 pb-10 pt-6 flex flex-col flex-1 justify-between">
                            <p>
                                Praeterea iter est quasdam res quas ex communi. Ullamco laboris nisi ut aliquid ex ea commodi consequat. Me non paenitet nullum festiviorem excogitasse ad hoc.
                            </p>

                            <div class="mt-6">
                                <button class="btn btn-primary w-full text-lg">Get started</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-200 pb-12">
        <div class="container">
            <div class="row justify-center">
                <div class="col-lg-10">
                    <div class="rounded-lg overflow-hidden">
                        <div class="bg-white px-10 py-8">
                            <div class="flex flex-col xl:flex-row lg:items-center lg:items-start justify-between">
                                <div class="max-w-sm lg:max-w-md mb-6">
                                    <h5 class="text-lg font-semibold text-gray-800">Sign up for our newsletter</h5>

                                    <p class="mt-2 text-base text-gray-500">
                                        Want to hear from us when we add new products or news updates? Sign up for our newsletter and we'll email you every time we do something new.
                                    </p>
                                </div>

                                <div class="flex flex-1 justify-end ml-20">
                                    <form class="flex flex-col flex-1 bg-pink-200 items-center md:items-start">
                                        <div class="flex flex-col flex-1 lg:flex-row items-center w-full">
                                            <input type="email" name="email" id="email" class="form-input block mr-0 mb-3 lg:mr-3 lg:mb-0 w-full" placeholder="Enter your email address">

                                            <button class="btn btn-primary">Notify me</button>
                                        </div>

                                        <div class="mt-2 text-sm text-right">
                                            <span class="text-gray-500">We care about your privacy. Read our <a class="text-indigo-500 hover:text-indigo-400" href="{{ route('privacy') }}">Privacy Policy</a>.</span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
