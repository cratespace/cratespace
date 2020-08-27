<template>
    <div>
        <div class="progress rounded-full overflow-hidden">
            <div class="progress-bar progress-bar-striped progress-bar-animated rounded-full" role="progressbar" :style="'width: '+progress+'%'" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="mt-2 flex items-center justify-between text-sm font-medium">
            <span class="text-gray-800">Order placed</span>
            <span v-for="label in Object.keys(labels)">
                <span :class="label === progressLabel ? 'text-blue-500' : 'text-gray-500'">{{ label }}</span>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['order'],

        data() {
            return {
                progress: 31,
                progressLabel: null,
                labels: {
                    'Pending': 31,
                    'Approved': 52,
                    'Shipped': 74,
                    'Delivered': 100,
                }
            }
        },

        mounted() {
            this.progress = this.labels[this.order.status];
            this.progressLabel = this.order.status;

            Echo.channel('order-tracker')
                .listen('OrderStatusUpdatedEvent', (event) => {
                    this.progressLabel = event.order.status;

                    this.progress = this.labels[event.order.status];
                });
        }
    }
</script>
