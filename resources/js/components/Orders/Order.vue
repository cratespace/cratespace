<template>
    <tr>
        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-16 w-16">
                    <div class="flex justify-center items-center h-16 w-16 bg-indigo-100 rounded-full">
                        <div class="text-center">
                            <div class="text-xs font-semibold text-indigo-900 uppercase">{{ '#' + order.uid }}</div>
                        </div>
                    </div>
                </div>

                <div class="ml-4">
                    <div class="text-sm leading-5 font-medium text-gray-900">{{ order.name }}</div>
                    <div class="text-sm leading-5 text-gray-600">{{ order.phone }}</div>

                    <div>
                        <a :href="order.path" class="font-semibold text-indigo-500 text-xs uppercase">{{ '#' + order.space.uid }}</a>
                    </div>
                </div>
            </div>
        </td>

        <td class="px-6 py-4 whitespace-no-wrap border-b text-sm leading-5 border-gray-200">
            <div class="text-gray-800 whitespace-no-wrap">{{ format(order.created_at) }}</div>

            <div class="text-gray-600 whitespace-no-wrap">{{ diffForHumans(order.space.departs_at) }}</div>
        </td>

        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-600">
            <div class="text-gray-900 whitespace-no-wrap">{{ '$' + order.total }}</div>
            <div class="text-gray-600 whitespace-no-wrap">USD</div>
        </td>

        <td class="px-6 py-4 whitespace-no-wrap text-sm border-b border-gray-200">
            <span class="relative inline-block px-3 py-1 font-semibold leading-tight" :class="{ 'text-yellow-800': status === 'Pending', 'text-indigo-800': status === 'Confirmed', 'text-green-800': status === 'Completed', 'text-red-800': status === 'Canceled'  }">
                <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full"
                :class="{ 'bg-yellow-200': status === 'Pending', 'bg-indigo-200': status === 'Confirmed', 'bg-green-200': status === 'Completed', 'bg-red-200': status === 'Canceled'  }"></span>
                <span class="relative">{{ status }}</span>
            </span>
        </td>

        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
            <div class="dropdown ml-auto">
                <button class="dropdown-toggle focus:outline-none" id="userDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg class="h-6 w-6 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                    </svg>
                </button>

                <div class="dropdown-menu dropdown-menu-right rounded-lg shadow-lg z-50 mt-3" aria-labelledby="userDropDown">
                    <a href="#" v-if="statuses.includes('Confirmed')" @click.prevent="updateStatus('Confirmed')" class="dropdown-item font-medium block px-4 py-2 text-sm">Confirm</a>
                    <a href="#" v-if="statuses.includes('Completed')" @click.prevent="updateStatus('Completed')" class="dropdown-item font-medium block px-4 py-2 text-sm">Complete</a>
                    <a href="#" v-if="statuses.includes('Pending')" @click.prevent="updateStatus('Pending')" class="dropdown-item font-medium block px-4 py-2 text-sm">Pending</a>
                    <a href="#" v-if="statuses.includes('Canceled')" @click.prevent="updateStatus('Canceled')" class="dropdown-item font-medium block px-4 py-2 text-sm">Cancel</a>
                </div>
            </div>
        </td>
    </tr>
</template>

<script>
    import helpers from '../../mixins/helpers';

    export default {
        props: ['data'],

        mixins: [helpers],

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
