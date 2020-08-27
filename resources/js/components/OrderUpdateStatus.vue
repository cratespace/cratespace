<template>
    <div class="dropdown">
        <a class="btn btn-secondary inline-flex items-center dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span v-show="loading">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>

            <span>{{ order.status }}</span>
        </a>

        <div class="mt-3 dropdown-menu dropdown-menu-right rounded-lg shadow-lg" aria-labelledby="dropdownMenuLink">
            <a v-for="status in statuses" class="dropdown-item text-sm font-medium text-gray-600 hover:text-gray-700 focus:text-white active:text-white py-2" :class="status === order.status ? 'active': ''" href="#" @click.prevent="updateStatus(status)" role="button">
                {{ status }}
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['statuses', 'order'],

        data() {
            return {
                loading: false
            }
        },

        methods: {
            updateStatus(status) {
                this.loading = true;

                axios.put(`/orders/${this.order.confirmation_number}`, {
                        status: status
                    })
                    .then((response) => {
                        if (response.status === 201) {
                            this.order = response.data;

                            this.loading = false;
                        }
                    });
            }
        }
    }
</script>
