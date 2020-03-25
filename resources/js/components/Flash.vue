<template>
    <div v-show="show" class="fixed bottom-0 right-0 mr-5 mb-5 alert alert-dismissable bg-white rounded-lg shadow-lg overflow-hidden fade show px-4 py-5 sm:px-6 max-w-sm" role="alert">
        <button type="button" class="close font-normal" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="flex">
            <div class="mr-3">
                <svg class="h-8 w-8 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>

            <div class="mr-4">
                <div class="font-semibold">Success!</div>

                <p class="text-gray-600">
                    {{ body }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message'],

        data() {
            return {
                body: this.message,
                show: false
            }
        },

        created() {
            if (this.body) {
                this.flash();
            }

            window.events.$on(
                'flash', data => this.flash(data)
            );
        },

        methods: {
            flash(data) {
                if (data) {
                    this.body = data.message;
                }

                this.show = true;

                this.hide();
            },

            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    };
</script>
