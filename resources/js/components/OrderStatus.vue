<template>
    <div>
        <div class="progress rounded-full overflow-hidden">
            <div class="progress-bar progress-bar-striped progress-bar-animated rounded-full" role="progressbar" :style="'width: '+progress+'%'" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="mt-2 flex items-center justify-between text-sm font-medium">
            <span class="text-gray-800">Order placed</span>
            <span v-for="label in Object.keys(labels)">
                <span :class="label === progressLabel || label === 'Processing' ? 'text-blue-500' : 'text-gray-500'">{{ label }}</span>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                progress: 31,
                progressLabel: null,
                labels: {
                    'Processing': 31,
                    'Approved': 54,
                    'Shipped': 67,
                    'Delivered': 100,
                }
            }
        },

        mounted() {
            Echo.channel('order-tracker')
                .listen('OrderStatusUpdatedEvent', (event) => {
                    this.progressLabel = event.order.status;

                    this.progress = this.labels[event.order.status];
                });
        }
    }
</script>
