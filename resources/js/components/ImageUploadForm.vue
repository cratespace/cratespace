<template>
    <div class="flex items-center">
        <div class="mr-4 w-20">
            <img class="h-20 w-20 rounded-full" :src="photo"/>
        </div>

        <div>
            <label for="avatar" class="block mb-2">
                <span class="text-sm font-semibold">{{ label }}</span>
            </label>

            <label class="btn shadow-none text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 hover:text-gray-800 cursor-pointer">
                <span>Change</span>

                <input class="hidden" type="file" accept="image/*" @change="onChange">
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['image', 'route', 'label'],

        data() {
            return {
                photo: this.image
            }
        },

        methods: {
            onChange(e) {
                if (! e.target.files.length) return;

                let file = e.target.files[0];

                let reader = new FileReader();

                reader.readAsDataURL(file);

                reader.onload = e => {
                    this.photo = e.target.result;
                };

                this.persist(file);
            },

            persist(image) {
                let data = new FormData();

                data.append('image', image);

                axios.post(this.route, data).then(() => flash('Image uploaded to server.'));
            }
        }
    }
</script>
