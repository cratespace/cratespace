<template>
    <div class="bg-white px-4 py-5 sm:px-6 rounded-lg shadow">
        <div>
            <div class="mb-2">
                <span class="relative inline-block px-3 py-1 font-semibold leading-tight text-xs" :class="{ 'text-yellow-800': status === 'Pending', 'text-indigo-800': status === 'Confirmed', 'text-green-800': status === 'Completed', 'text-red-800': status === 'Canceled'  }">
                    <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full"
                    :class="{ 'bg-yellow-200': status === 'Pending', 'bg-indigo-200': status === 'Confirmed', 'bg-green-200': status === 'Completed', 'bg-red-200': status === 'Canceled'  }"></span>
                    <span class="relative">{{ status }}</span>
                </span>
            </div>

            <div class="font-semibold">
                <span class="text-gray-700">Order </span> <span class="text-indigo-500 uppercase">{{ '#' + order.uid }}</span>
            </div>
        </div>

        <div class="mt-6">
            <div>
                <div class="text-xs font-medium text-gray-600">Customer name</div>
                <div class="text-sm font-semibold text-gray-700">{{ order.name }}</div>
            </div>

            <div class="mt-4">
                <div class="text-xs font-medium text-gray-600">Customer email address</div>
                <div>
                    <a :href="'mialto:' + order.email" class="text-sm font-medium text-indigo-500 hover:text-indigo-400">{{ order.email }}</a>
                </div>
            </div>

            <div class="mt-4">
                <div class="text-xs font-medium text-gray-600">Customer phone</div>
                <div class="text-sm font-semibold text-gray-700">{{ order.phone }}</div>
            </div>

            <div class="mt-4">
                <div>
                    <div class="text-xs font-medium text-gray-600">Service charge</div>
                    <div class="text-sm font-semibold text-gray-700">{{ '$' + order.service }}</div>
                </div>

                <div class="mt-2">
                    <div class="text-xs font-medium text-gray-600">Tax amount</div>
                    <div class="text-sm font-semibold text-gray-700">{{ '$' + order.tax }}</div>
                </div>

                <div class="mt-2">
                    <div class="text-xs font-medium text-gray-600">Total</div>
                    <div class="text-xl font-semibold text-gray-700">{{ '$' + order.total }}</div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <div class="dropdown flex items-center justify-end">
                <button class="dropdown-toggle focus:outline-none btn btn-secondary text-sm px-4 py-2 ml-auto flex items-center" id="orderDrop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Update status

                    <svg class="-mr-1 ml-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <div class="dropdown-menu dropdown-menu-right rounded-lg shadow-lg z-50 mt-3" aria-labelledby="orderDrop">
                    <a href="#" v-if="statuses.includes('Confirmed')" @click.prevent="updateStatus('Confirmed')" class="dropdown-item font-medium block px-4 py-2 text-sm">Confirm</a>
                    <a href="#" v-if="statuses.includes('Completed')" @click.prevent="updateStatus('Completed')" class="dropdown-item font-medium block px-4 py-2 text-sm">Complete</a>
                    <a href="#" v-if="statuses.includes('Pending')" @click.prevent="updateStatus('Pending')" class="dropdown-item font-medium block px-4 py-2 text-sm">Pending</a>
                    <a href="#" v-if="statuses.includes('Canceled')" @click.prevent="updateStatus('Canceled')" class="dropdown-item font-medium block px-4 py-2 text-sm">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data'],

        data() {
            return {
                order: this.data,
                status: this.data.status,
                statuses: ['Pending', 'Confirmed', 'Completed', 'Canceled'],
            }
        },

        created() {
            this.setCurrentStatus();
        },

        methods: {
            updateStatus(status) {
                axios.put(this.order.path, {
                        status: status
                    })
                    .then((response) => {
                        if (response.status == 200) {
                            this.status = response.data.message;
                        }

                        flash("Order status updated");
                    });
            },

            setCurrentStatus() {
                const index = this.statuses.indexOf(this.status);

                if (index > -1) {
                    this.statuses.splice(index, 1);
                }
            }
        }
    }
</script>
