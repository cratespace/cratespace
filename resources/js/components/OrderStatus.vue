<template>
    <div>
        <div class="progress rounded-full overflow-hidden">
            <div class="progress-bar progress-bar-striped progress-bar-animated rounded-full" role="progressbar" :style="'width: '+progress+'%'" :aria-valuenow="progress" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <div class="mt-2 flex items-center justify-between text-sm font-medium">
            <span class="text-gray-800">Order placed</span>
            <span class="text-gray-800">Processing</span>
            <span class="text-gray-800">Approved</span>
            <span class="text-gray-800">Shipped</span>
            <span class="text-green-500">Delivered</span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                progress: 30,
                progressLabel: null,
                labels: {
                    'Pending': 0,
                    'Processing': 30,
                    'Approved': 45,
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

                    // this.progress = event.value;
                });
        }
    }
</script>
