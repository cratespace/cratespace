<template>
    <guest-layout>
        <div class="md:grid md:grid-cols-12 md:gap-6">
            <div class="md:col-span-6 xl:col-span-7">
                <div>
                    <div>
                        <span class="text-xs font-medium text-blue-500 ">
                            {{ product.business }}
                        </span>
                    </div>

                    <div>
                        <h6 class="text-sm font-semibold">{{ product.code }}</h6>
                    </div>

                    <div class="mt-3">
                        <h2 class="text-3xl font-bold">{{ product.amount }}</h2>
                    </div>

                    <div class="mt-10">
                        <div>
                            <div>
                                <span class="text-gray-400 text-xs font-medium">Dimensions in feet</span>
                            </div>

                            <div>
                                <span class="text-xl font-semibold">
                                    {{ product.height }} x {{ product.width }} x {{ product.length }}
                                </span>
                            </div>

                            <div>
                                <span class="text-gray-400 text-xs font-medium">
                                    Height - Width - Length
                                </span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div>
                                <span class="text-gray-400 text-xs font-medium">Max. allowable weight</span>
                            </div>

                            <div>
                                <span class="text-xl font-semibold">
                                    ~ {{ product.weight }}
                                </span>
                            </div>

                            <div>
                                <span class="text-gray-400 text-xs font-medium">
                                    Kilograms
                                </span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div>
                                <span class="text-gray-400 text-xs font-medium">Departs from</span>
                            </div>

                            <div>
                                <div>
                                    <div>
                                        <span class="text-sm font-semibold">
                                            {{ product.origin.city }}, {{ product.origin.country }}
                                        </span>
                                    </div>

                                    <div>
                                        on
                                        <span class="cursor-pointer text-sm font-semibold">
                                            <time :datetime="product.departs_at">{{ expanded(product.departs_at) }}</time>
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <span class="text-gray-400 text-xs">
                                        Will depart <time :datetime="product.departs_at">{{ diffForHumans(product.departs_at) }}</time>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <div>
                                <span class="text-gray-400 text-xs font-medium">Arrives at</span>
                            </div>

                            <div>
                                <div>
                                    <div>
                                        <span class="text-sm font-semibold">
                                            {{ product.destination.city }}, {{ product.destination.country }}
                                        </span>
                                    </div>

                                    <div>
                                        on
                                        <span class="cursor-pointer text-sm font-semibold">
                                            <time :datetime="product.arrives_at">{{ expanded(product.arrives_at) }}</time>
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <span class="text-gray-400 text-xs">
                                        Will arrive <time :datetime="product.arrives_at">{{ diffForHumans(product.arrives_at) }}</time>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 md:mt-0 md:col-span-6 xl:col-span-5">
                <card>
                    <template #content>
                        <form @submit.prevent="purchase">
                            <div>
                                <app-input type="text" v-model="form.name" :error="form.errors.name" label="Full name" placeholder="Johnathan Doeford"></app-input>
                            </div>

                            <div class="mt-6">
                                <app-input type="text" v-model="form.business" :error="form.errors.business" label="Business name" placeholder="Leming & Leming"></app-input>

                                <div class="mt-1">
                                    <span class="text-xs font-gray-400">
                                        A business name is optional and does not need to be filled.
                                    </span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <app-input type="email" v-model="form.email" :error="form.errors.email" label="Email address" placeholder="john.doe@example.com"></app-input>
                            </div>

                            <div class="mt-6">
                                <app-input type="tel" v-model="form.phone" :error="form.errors.phone" label="Phone number" placeholder="07xxxxxxxx"></app-input>
                            </div>

                            <div class="mt-6">
                                <app-input-label text="Card information">
                                    <div id="card-element"></div>
                                </app-input-label>

                                <app-input-error :message="cardErrorMessage"></app-input-error>
                            </div>

                            <div class="flex items-center justify-end mt-8">
                                <app-button type="submit" mode="primary" class="justify-center w-full px-5 py-3" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                                    Pay {{ product.amount }}
                                </app-button>
                            </div>
                        </form>
                    </template>
                </card>
            </div>
        </div>
    </guest-layout>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
import GuestLayout from '@/Views/Layouts/GuestLayout';
import AppLink from '@/Views/Components/Base/Link';
import Card from '@/Views/Components/Cards/Card.vue';
import AppInput from '@/Views/Components/Inputs/Input';
import AppInputLabel from '@/Views/Components/Inputs/InputLabel';
import AppInputError from '@/Views/Components/Inputs/InputError';
import AppButton from '@/Views/Components/Buttons/Button';

export default {
    components: {
        GuestLayout,
        AppLink,
        Card,
        AppInput,
        AppInputLabel,
        AppInputError,
        AppButton,
    },

    props: [
        'user',
        'payementToken',
        'product',
        'stripeKey',
    ],

    data() {
        return {
            form: this.$inertia.form({
                name: this.user.name,
                email: this.user.email,
                phone: this.user.phone,
                payment_method: null,
                payment_token: this.payementToken,
                business: null,
                product: this.product.code
            }),

            stripe: null,
            cardElement: null,
            cardErrorMessage: null,
        }
    },

    created() {
        this.initializeStripe();
    },

    methods: {
        purchase() {
            this.stripe.createPaymentMethod({
                type: 'card',
                card: this.cardElement,
                billing_details: {
                    name: this.form.name,
                    email: this.form.email,
                    phone: this.form.phone,
                }
            }).then((response) => {
                console.log(response.paymentMethod.id);

                this.form.payment_method = response.paymentMethod.id;

                this.form.post(this.route('orders.store'), {
                    preserveScroll: true,
                });
            });
        },

        async initializeStripe() {
            this.stripe = await loadStripe(this.stripeKey);

            const elements = this.stripe.elements();

            this.cardElement = elements.create('card', {
                'classes': {
                    'base': 'form-input px-4 pt-3 pb-2 mt-1 block w-full rounded-lg bg-white border border-gray-200 placeholder-gray-400 transition ease-in-out duration-150',

                    'focus': 'outline-none border-blue-500 ring ring-blue-500 ring-opacity-50'
                },

                'hidePostalCode': true
            });

            this.cardElement.addEventListener('change', (event) => {
                this.cardErrorMessage = event.error ? event.error.message : null;
            });

            this.cardElement.mount('#card-element');
        }
    }
};
</script>
