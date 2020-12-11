<template>
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
</template>

<script>
    export default {
        props: ['user'],

        data() {
            form: new Form({
                photo: null
            }),

            photoPreview: null,
        },

        methods: {
            updateProfileInformation() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('user-profile-information.update'), {
                    preserveScroll: true
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(this.$refs.photo.files[0]);
            },

            deletePhoto() {
                this.$inertia.delete(route('current-user-photo.destroy'), {
                    preserveScroll: true,
                }).then(() => {
                    this.photoPreview = null
                });
            },
        }
    }
</script>
