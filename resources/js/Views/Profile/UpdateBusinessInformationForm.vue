<template>
    <action-section>
        <template #title>
            Business Information
        </template>

        <template #description>
            Update your business profile information and address details.
        </template>

        <template #content>
            <form @submit.prevent="updateBusinessInformation">
                <div class="lg:grid lg:grid-cols-12 gap-6">
                    <div class="col-span-12">
                        <input type="file" class="hidden" ref="photo" @change="updatePhotoPreview">

                        <div class="flex items-center">
                            <div v-show="! photoPreview">
                                <img :src="business.profile_photo_url" :alt="business.name" class="rounded-full h-20 w-20 object-cover">
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

                                    <app-button class="ml-4" type="button" mode="secondary" @click.native.prevent="deletePhoto" v-if="business.profile_photo_path">
                                        Remove
                                    </app-button>
                                </div>

                                <app-input-error :message="form.errors.photo" class="mt-2"></app-input-error>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 lg:mt-0 md:col-span-8">
                        <app-input type="text" v-model="form.name" :error="form.errors.name" label="Business name" placeholder="Johnathan Doeford"></app-input>
                    </div>

                    <div class="mt-6 lg:mt-0 md:col-span-8">
                        <app-textarea type="text" v-model="form.about" :error="form.errors.about" label="About" placeholder="" rows="7"></app-textarea>
                    </div>

                    <div class="mt-6 lg:mt-0 md:col-span-6">
                        <app-input type="text" v-model="form.street" :error="form.errors.street" label="Street" placeholder="2308 Harry Place"></app-input>
                    </div>

                    <div class="mt-6 lg:mt-0 md:col-span-6">
                        <app-input type="text" v-model="form.city" :error="form.errors.city" label="Town/City" placeholder="Charlotte"></app-input>
                    </div>

                    <div class="mt-6 lg:mt-0 md:col-span-6">
                        <app-input type="text" v-model="form.state" :error="form.errors.state" label="State/Province" placeholder="North Carolina"></app-input>
                    </div>

                    <div class="mt-6 lg:mt-0 md:col-span-6">
                        <app-input type="text" v-model="form.country" :error="form.errors.country" label="Country" placeholder="United States"></app-input>
                    </div>

                    <div class="mt-6 lg:mt-0 md:col-span-6">
                        <app-input type="text" v-model="form.postcode" :error="form.errors.postcode" label="Postcode" placeholder="28263"></app-input>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <action-message :on="form.recentlySuccessful" class="mr-4">
                        Changes saved. <span class="ml-1">&check;</span>
                    </action-message>

                    <app-button type="submit" mode="primary" :class="{ 'opacity-25': form.processing }" :loading="form.processing">
                        Save changes <span class="ml-1">&rarr;</span>
                    </app-button>
                </div>
            </form>
        </template>
    </action-section>
</template>

<script>
import ActionSection from '@/Views/Components/Sections/ActionSection';
import AppInput from '@/Views/Components/Inputs/Input';
import AppTextarea from '@/Views/Components/Inputs/Textarea';
import AppInputError from '@/Views/Components/Inputs/InputError';
import AppButton from '@/Views/Components/Buttons/Button';
import ActionMessage from '@/Views/Components/Alerts/ActionMessage';

export default {
    props: ['business'],

    components: {
        ActionSection,
        AppInput,
        AppTextarea,
        AppInputError,
        AppButton,
        ActionMessage
    },

    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                name: this.business.name,
                about: this.business.about,
                street: this.business.street,
                city: this.business.city,
                state: this.business.state,
                country: this.business.country,
                postcode: this.business.postcode,
                photo: null
            }),

            photoPreview: null,
        }
    },

    methods: {
        updateBusinessInformation() {
            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0];
            }

            this.form.post(this.route('user.business'), {
                errorBag: 'updateBusinessInformation',
                preserveScroll: true,
            });
        },

        selectNewPhoto() {
            this.$refs.photo.click();
        },

        updatePhotoPreview() {
            const reader = new FileReader();

            reader.onload = event => this.photoPreview = event.target.result;

            reader.readAsDataURL(this.$refs.photo.files[0]);
        },

        deletePhoto() {
            this.$inertia.delete(this.route('user-photo.destroy'), {
                preserveScroll: true,
                onSuccess: () => this.photoPreview = null
            });
        },
    }
}
</script>
