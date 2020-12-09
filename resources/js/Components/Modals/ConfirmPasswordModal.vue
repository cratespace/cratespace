<template>
    <span>
        <span @click="startConfirmingPassword">
            <slot></slot>
        </span>

        <modal :name="name">
            <form-card @submitted="confirmPassword">
                <template #form>
                    <div class="modal-header p-0">
                        <h5 class="modal-title text-gray-800 font-semibold text-lg" :id="name + 'Label'">
                            Confirm Password
                        </h5>
                    </div>

                    <div class="modal-body mt-3 p-0">
                        <div>
                            <p class="text-gray-600">
                                For your security, please confirm your password to continue.
                            </p>
                        </div>

                        <div class="mt-6">
                            <app-input type="password" v-model="form.password" :error="form.error('password')" ref="password" label="Password" placeholder="cattleFarmer1576@!"></app-input>
                        </div>
                    </div>
                </template>

                <template #actions>
                    <app-button mode="secondary" type="button" data-dismiss="modal">
                        Cancel
                    </app-button>

                    <app-button class="ml-3" mode="primary" type="submit" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                        Confirm
                    </app-button>
                </template>
            </form-card>
        </modal>
    </span>
</template>

<script>
    import Modal from '@/Components/Modals/Modal';
    import AppInput from '@/Components/Inputs/Input';
    import AppButton from '@/Components/Buttons/Button';
    import FormCard from '@/Components/Cards/FormCard';

    export default {
        props: ['name'],

        components: {
            Modal,
            AppButton,
            AppInput,
            FormCard,
        },

        data() {
            return {
                form: new Form({
                    password: null
                }),
            }
        },

        methods: {
            startConfirmingPassword() {
                this.form.errors.clearAll();

                axios.get(route('password.confirmation'))
                    .then(response => {
                        if (response.data.confirmed) {
                            this.$emit('confirmed');
                        } else {
                            $('#' + this.name).modal('show');

                            this.form.password = null;

                            setTimeout(() => {
                                this.$refs.password.focus()
                            }, 250)
                        }
                    });
            },

            confirmPassword() {
                this.form.processing = true;

                this.form.post('/user/confirm-password')
                    .then(() => {
                        if (! this.form.hasErrors()) {
                            $('#' + this.name).modal('hide');

                            this.$emit('confirmed');
                        }
                    });
            }
        }
    }
</script>

