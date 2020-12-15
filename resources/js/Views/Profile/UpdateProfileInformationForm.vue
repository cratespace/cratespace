<template>
    <form-section @submitted="updateProfileInformation()">
        <template #title>
            Profile information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <div class="row">
                <div class="col-12">
                    <input type="file" class="hidden" ref="photo" @change="updatePhotoPreview">

                    <div class="flex items-center">
                        <div v-show="! photoPreview">
                            <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                        </div>

                        <div class="mt-2" v-show="photoPreview">
                            <span class="block rounded-full w-20 h-20"
                                  :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                            </span>
                        </div>

                        <div class="ml-4">
                            <div class="flex items-center">
                                <app-button type="button" mode="secondary" @click.native.prevent="selectNewPhoto">
                                    Change
                                </app-button>

                                <app-button class="ml-4" type="button" mode="secondary" @click.native.prevent="deletePhoto" v-if="user.profile_photo_path">
                                    Remove
                                </app-button>
                            </div>

                            <input-error :message="form.error('photo')" class="mt-2"></input-error>
                        </div>
                    </div>
                </div>

                <div class="mt-6 col-lg-6">
                    <app-input type="text" v-model="form.name" :error="form.error('name')" label="Full name" placeholder="Johnathan Doe"></app-input>
                </div>

                <div class="mt-6 col-lg-6">
                    <app-input type="text" v-model="form.username" :error="form.error('username')" label="Username" placeholder="JohnTheFarmer"></app-input>
                </div>

                <div class="mt-6 col-lg-6">
                    <app-input type="email" v-model="form.email" :error="form.error('email')" label="Email address" placeholder="john.doe@example.com"></app-input>
                </div>

                <div class="mt-6 col-lg-6">
                    <app-input type="tel" v-model="form.phone" :error="form.error('phone')" label="Phone number" placeholder="701897361"></app-input>
                </div>
            </div>
        </template>

        <template #actions>
            <action-message :on="form.recentlySuccessful" class="mr-4">
                Changes saved. <span class="ml-1">&check;</span>
            </action-message>

            <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                Save changes
            </app-button>
        </template>
    </form-section>
</template>

<script>
    import FormSection from '@/Components/Sections/FormSection';
    import AppInput from '@/Components/Inputs/Input';
    import InputError from '@/Components/Inputs/InputError';
    import AppButton from '@/Components/Buttons/Button';
    import ActionMessage from '@/Components/Alerts/ActionMessage';

    export default {
        props: ['user'],

        components: {
            FormSection,
            InputError,
            AppInput,
            AppButton,
            ActionMessage,
        },

        data() {
            return {
                form: new Form({
                    '_method': 'PUT',
                    name: this.user.name,
                    username: this.user.username,
                    email: this.user.email,
                    phone: this.user.phone,
                    photo: null,
                }, {
                    resetOnSuccess: false,
                }),

                deletePhotoForm: new Form({
                    '_method': 'DELETE',
                }),

                photoPreview: null,
            }
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0];
                }

                this.form.post(route('profile.update'))
                    .then(() => {
                        this.$emit('updated');
                    });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (event) => {
                    this.photoPreview = event.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.deletePhotoForm.post(route('user-photo.destroy'))
                    .then(() => {
                        this.photoPreview = null;

                        this.$emit('updated');
                    });
            },
        }
    }
</script>
