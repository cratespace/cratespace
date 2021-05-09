<template>
    <auth-layout>
        <template #left>
            <div class="bg-gradient-to-br from-gray-100 to-gray-50 h-full p-10">
                <div>
                    <logo :title="config('app.name')" classes="h-16 w-16 text-blue-500"></logo>
                </div>

                <div class="mt-6">
                    <div>
                        <div>
                            <span class="text-xs font-medium text-blue-500">
                                {{ product.business }}
                            </span>
                        </div>

                        <div>
                            <h6 class="text-sm font-semibold">{{ product.code }}</h6>
                        </div>

                        <div class="mt-3">
                            <h2 class="text-3xl font-bold">{{ product.amount }}</h2>
                        </div>
                    </div>

                    <div class="mt-6">
                        <div class="flex">
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

                            <div class="ml-6">
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
        </template>

        <template #right>
            <div>
                <div>
                    <div class="mb-6 block lg:hidden">
                        <logo :title="config('app.name')" classes="h-16 w-16 text-blue-500"></logo>
                    </div>

                    <h4 class="mt-6 font-semibold text-xl text-gray-800">Payment details</h4>

                    <p class="mt-3 font-normal text-base text-gray-500">
                        Please make the payment, after that you can enjoy the benefits.
                    </p>
                </div>

                <div class="mt-6">
                    <form @submit.prevent="purchase" class="w-full lg:grid lg:grid-cols-12 gap-6">
                        <div class="mt-6 lg:mt-0 lg:col-span-6">
                            <app-input type="text" v-model="form.name" :error="form.errors.name" label="Full name" placeholder="Johnathan Doeford"></app-input>
                        </div>

                        <div class="mt-6 lg:mt-0 lg:col-span-6">
                            <app-input type="text" v-model="form.business" :error="form.errors.business" label="Business name" placeholder="Leming & Leming"></app-input>
                        </div>

                        <div class="mt-6 lg:mt-0 lg:col-span-6">
                            <app-input type="email" v-model="form.email" :error="form.errors.email" label="Email address" placeholder="john.doe@example.com"></app-input>
                        </div>

                        <div class="mt-6 lg:mt-0 lg:col-span-6">
                            <app-input type="tel" v-model="form.phone" :error="form.errors.phone" label="Phone number" placeholder="07xxxxxxxx"></app-input>
                        </div>

                        <div class="mt-6 lg:mt-0 lg:col-span-8">
                            <app-input-label text="Card information">
                                <div id="card-element"></div>
                            </app-input-label>

                            <app-input-error :message="cardErrorMessage"></app-input-error>
                        </div>

                        <div class="mt-6 lg:mt-0 col-span-12">
                            <p class="font-normal text-xs text-gray-400 max-w-sm">
                                By clicking "Pay", you agree to Cratespace's <app-link href="#">Terms of Use</app-link> and acknowledge you have read the <app-link href="#">Privacy Policy</app-link>.
                            </p>
                        </div>

                        <div class="mt-6 lg:mt-0 col-span-12">
                            <app-button type="submit" mode="primary" class="justify-center w-full px-5 py-3" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                                Pay {{ product.amount }}
                            </app-button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </auth-layout>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
import Logo from '@/Views/Components/Logos/Logo';
import AuthLayout from '@/Views/Layouts/AuthLayout';
import AppLink from '@/Views/Components/Base/Link';
import Card from '@/Views/Components/Cards/Card.vue';
import AppInput from '@/Views/Components/Inputs/Input';
import AppInputLabel from '@/Views/Components/Inputs/InputLabel';
import AppInputError from '@/Views/Components/Inputs/InputError';
import AppButton from '@/Views/Components/Buttons/Button';

export default {
    components: {
        AuthLayout,
        AppLink,
        Card,
        Logo,
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
                classes: {
                    'base': 'form-input px-4 py-2 mt-1 block w-full rounded-lg bg-white border border-gray-200 placeholder-gray-400 transition ease-in-out duration-150 font-sans leading-normal text-base',

                    'focus': 'outline-none border-blue-500 ring ring-blue-500 ring-opacity-50'
                },

                style: {
                    base: {
                        color: '#4B5563',
                        fontFamily: 'Inter, Roboto, Open Sans, Segoe UI, sans-serif',
                        fontSize: '16px',
                        lineHeight: '24px',
                        fontSmoothing: 'antialiased',
                    }
                },

                hidePostalCode: true
            });

            this.cardElement.addEventListener('change', (event) => {
                this.cardErrorMessage = event.error ? event.error.message : null;
            });

            this.cardElement.mount('#card-element');
        }
    }
};
</script>
