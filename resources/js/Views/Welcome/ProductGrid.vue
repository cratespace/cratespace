<template>
    <div class="mt-6 md:grid md:grid-cols-12 md:gap-6">
        <div class="mb-6 md:mb-0 md:col-span-6 lg:col-span-4">
            <card>
                <template #content>
                    <div>
                        <div>
                            <div>
                                <span class="text-xs font-medium text-blue-500 ">
                                    Example, Inc.
                                </span>
                            </div>

                            <div>
                                <h5 class="text-base font-bold">UEH893EO8EWQIUHSDUIQW</h5>
                            </div>
                        </div>

                        <div class="mt-3 flex justify-between">
                            <div class="flex justify-between space-x-2">
                                <div class="text-center">
                                    <div>
                                        <span class="rounded-lg py-1 px-2 border border-gray-200">
                                            <span class="text-lg font-medium">12</span> <span class="text-xs font-light">Ft</span>
                                        </span>
                                    </div>

                                    <div>
                                        <span class="text-gray-400 text-xs">Height</span>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div>
                                        <span class="rounded-lg py-1 px-2 border border-gray-200">
                                            <span class="text-lg font-medium">6</span> <span class="text-xs font-light">Ft</span>
                                        </span>
                                    </div>

                                    <div>
                                        <span class="text-gray-400 text-xs">Width</span>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div>
                                        <span class="rounded-lg py-1 px-2 border border-gray-200">
                                            <span class="text-lg font-medium">9</span> <span class="text-xs font-light">Ft</span>
                                        </span>
                                    </div>

                                    <div>
                                        <span class="text-gray-400 text-xs">Length</span>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <div>
                                    <span class="rounded-lg py-1 px-2 border border-gray-200">
                                        <span class="text-lg font-medium">1240</span> <span class="text-xs font-light">kg</span>
                                    </span>
                                </div>

                                <div>
                                    <span class="text-gray-400 text-xs">Max weight</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center">
                            <div class="flex-1">
                                <div>
                                    <span class="text-gray-400 text-xs uppercase font-medium tracking-wide">From</span>
                                </div>

                                <div>
                                    <div>
                                        <span class="text-sm font-semibold">
                                            Colombo
                                        </span>
                                    </div>

                                    <div>
                                        <span class="text-gray-400 text-xs">Sri Lanka</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1">
                                <div>
                                    <span class="text-gray-400 text-xs uppercase font-medium tracking-wide">To</span>
                                </div>

                                <div>
                                    <div>
                                        <span class="text-sm font-semibold">
                                            Jaffna
                                        </span>
                                    </div>

                                    <div>
                                        <span class="text-gray-400 text-xs">Sri Lanka</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center">
                            <div class="flex-1">
                                <div>
                                    <span class="text-gray-400 text-xs uppercase font-medium tracking-wide">Departure</span>
                                </div>

                                <div>
                                    <div>
                                        <span class="cursor-pointer text-sm font-semibold">
                                            <time datetime="2021-03-28">Sun, Mar 28</time>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1">
                                <div>
                                    <span class="text-gray-400 text-xs uppercase font-medium tracking-wide">Arrival</span>
                                </div>

                                <div>
                                    <div>
                                        <span class="cursor-pointer text-sm font-semibold">
                                            <time datetime="2021-03-28">Sun, Mar 28</time>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <app-button mode="primary" href="#" :link="true" class="justify-center w-full px-5 py-3">
                                <span class="text-base">Buy for $12</span>
                            </app-button>
                        </div>
                    </div>
                </template>
            </card>
        </div>
    </div>
</template>

<script>
import Card from '@/Views/Components/Cards/Card';
import AppButton from '@/Views/Components/Buttons/Button';

export default {
    components: {
        Card,
        AppButton
    }
}
</script>
