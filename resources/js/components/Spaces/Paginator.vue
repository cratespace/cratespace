<template>
    <div class="col-12 flex items-center justify-between">
        <div class="flex items-center text-gray-600 text-sm">
            Showing
            <span class="font-medium mx-1">{{ from }}</span>
            to
            <span class="font-medium mx-1">{{ to }}</span>
            of
            <span class="font-medium mx-1">{{ total }}</span>
            results
        </div>

        <div v-if="shouldPaginate" class="flex-1 flex justify-between sm:justify-end">
            <a v-show="prevUrl" href="#" aria-label="Previous" rel="prev" @click.prevent="page--" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                <span aria-hidden="true">Previous</span>
            </a>

            <a v-show="nextUrl" href="#" aria-label="Next" rel="next" @click.prevent="page++" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                <span aria-hidden="true">Next</span>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false,
                from: null,
                to: null,
                total: null,
            };
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
                this.from = this.dataSet.from;
                this.to = this.dataSet.to;
                this.total = this.dataSet.total;
            },

            page() {
                this.broadcast().updateUrl();
            }
        },

        computed: {
            shouldPaginate() {
                return !!this.prevUrl || !!this.nextUrl;
            }
        },

        methods: {
            broadcast() {
                return this.$emit('changed', this.page);
            },

            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }
        }
    }
</script>
