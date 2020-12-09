<template>
    <form @submit.prevent="requestReset()" class="w-full">
        <div v-if="! message">
            <div class="mt-6 block">
                <app-input type="email" v-model="form.email" :error="form.error('email')" label="Email address" placeholder="john.doe@example.com"></app-input>
            </div>

            <div class="mt-6 block">
                <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing || this.message }" :loading="form.processing">
                    Request password reset link
                </app-button>
            </div>
        </div>

        <div v-else>
            <div class="mt-6 block">
                <span class="font-medium text-xs text-green-500" role="alert" v-text="message"></span>
            </div>
        </div>
    </form>
</template>

<script>
    import AppInput from '@/Components/Inputs/Input';
    import AppButton from '@/Components/Buttons/Button';

    export default {
        components: {
            AppInput,
            AppButton,
        },

        data() {
            return {
                form: new Form({
                    email: null,
                }),

                message: null
            }
        },

        methods: {
            requestReset() {
                this.form.post(route('password.email'))
                    .then(({ data }) => this.message = data.message);
            }
        }
    }
</script>
