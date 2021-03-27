<template>
    <div class="md:grid md:grid-cols-12 md:gap-6">
        <div class="col-span-12 overflow-hidden rounded-xl">
            <div class="px-6 py-5 md:px-12 md:py-10 bg-local bg-center bg-no-repeat bg-cover image lg:flex items-center">
                <div class="w-full lg:w-1/2">
                    <div>
                        <h1 class="text-3xl lg:text-4xl xl:text-5xl text-white font-light">Linking you to your <span class="font-bold">customers</span></h1>

                        <h6 class="mt-6 text-base md:text-lg lg:text-xl text-white max-w-sm">
                            Buy and sell on the platform with the largest network of active Logistics services.
                        </h6>
                    </div>

                    <div class="mt-6">
                        <app-button :link="true" href="#" mode="secondary">
                            Explore now <span class="ml-1">&rarr;</span>
                        </app-button>
                    </div>
                </div>

                <div class="mt-10 lg:mt-0 w-full lg:w-1/2">
                    <card class="shadow-xl">
                        <template #content>
                            <div>
                                <div class="flex items-center justify-between">
                                    <div class="mr-3 flex-1 rounded-xl border border-gray-200 overflow-hidden">
                                        <div class="px-4 py-5 bg-white sm:px-6">
                                            <div>
                                                <span class="text-xs uppercase font-semibold tracking-wide text-gray-500">From</span>
                                            </div>

                                            <div>
                                                <div>
                                                    <span class="text-xl font-bold">
                                                        Colombo
                                                    </span>
                                                </div>

                                                <div>
                                                    <span class="text-sm">Sri Lanka</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ml-3 flex-1 rounded-xl border border-gray-200 overflow-hidden">
                                        <div class="px-4 py-5 bg-white sm:px-6">
                                            <div>
                                                <span class="text-xs uppercase font-semibold tracking-wide text-gray-500">To</span>
                                            </div>

                                            <div>
                                                <div>
                                                    <span class="text-xl font-bold">
                                                        Jaffna
                                                    </span>
                                                </div>

                                                <div>
                                                    <span class="text-sm">Sri Lanka</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 rounded-xl border border-gray-200 overflow-hidden">
                                    <div class="flex items-center justify-between px-4 py-5 bg-white sm:px-6">
                                        <div class="flex-1">
                                            <div>
                                                <span class="text-xs uppercase font-semibold tracking-wide">Departure</span>
                                            </div>

                                            <div>
                                                <div>
                                                    <span class="text-xl font-bold">
                                                        Fri, Mar 26
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex-1">
                                            <div>
                                                <span class="text-xs uppercase font-semibold tracking-wide">Arriving</span>
                                            </div>

                                            <div>
                                                <div>
                                                    <span class="text-xl font-bold">
                                                        Sun, Mar 28
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 flex items-center justify-end">
                                    <app-button mode="primary" class="px-5 py-3">
                                        <span>
                                            Search available spaces <span class="ml-1">&rarr;</span>
                                        </span>
                                    </app-button>
                                </div>
                            </div>
                        </template>
                    </card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import flatPickr from 'vue-flatpickr-component';
  import 'flatpickr/dist/flatpickr.css';
import AppLink from '@/Views/Components/Base/Link';
import AppButton from '@/Views/Components/Buttons/Button';
import Card from '@/Views/Components/Cards/Card';

export default {
    components: {
        AppLink,
        AppButton,
        Card,
        flatPickr
    },

    data() {
        return {
            date: null
        }
    }
}
</script>

<style>
    .image {
        background-image: url("/img/hero.jpg");
    }
</style>
