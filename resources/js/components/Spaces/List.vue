<template>
    <div>
        <section class="pt-6">
            <div class="container">
                <div class="row items-center">
                    <div class="col-lg-5 mb-4 lg:mb-0">
                        <h2 class="text-2xl font-semibold text-gray-800 leading-tight">
                            Spaces
                        </h2>

                        <div class="flex items-center text-gray-600">
                            Add and manage your available spaces.
                        </div>
                    </div>

                    <div class="col-lg-7 mb-4 lg:mb-0 flex justify-end">
                        <div class="flex flex-1">
                            <div class="flex-1">
                                <div class="relative">
                                    <div class="absolute top-0 left-0 bottom-0 ml-3 flex items-center">
                                        <svg class="w-5 h-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>

                                    <input type="search" name="search" id="search" class="form-input block w-full bg-white pl-10 rounded-r-none border-r-none focus:outline-none focus:shadow-none" placeholder="Search..." @keyup.enter="fetch" v-model="search">
                                </div>
                            </div>

                            <div>
                                <label class="block relative">
                                    <div class="absolute top-0 left-0 bottom-0 ml-3 flex items-center">
                                        <svg class="w-5 h-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>

                                    <select name="status" id="status" class="-ml-px form-select bg-gray-100 block w-full pl-10 rounded-l-none border-l-none focus:z-10 focus:outline-none focus:shadow-none focus:border-none" v-model="status" @change="fetch">
                                        <option value="" selected>All</option>
                                        <option value="Available">Available</option>
                                        <option value="Ordered">Ordered</option>
                                        <option value="Purchased">Purchased</option>
                                        <option value="Expired">Expired</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mt-2 lg:mt-4">
            </div>
        </section>

        <section class="py-6">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="overflow-auto shadow rounded-lg">
                            <div class="rounded-lg overflow-hidden">
                                <div v-if="items.length !== 0">
                                    <div v-for="(space, index) in items" :key="space.id">
                                        <space :space="space"></space>
                                    </div>
                                </div>

                                <div v-else class="bg-white p-3">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>

                                        <span class="text-gray-600">No results found</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="pb-12">
            <div class="container">
                <div class="row">
                    <paginator :dataSet="dataSet" @changed="fetch"></paginator>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import collection from "./mixins/collection";
    import Space from './Space';
    import Paginator from './Paginator';

    export default {
        components: { Space, Paginator },

        mixins: [ collection ],

        data() {
            return {
                dataSet: false,
                search: '',
                status: '',
                perpage: 10,
            }
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page = 1) {
                axios.get(this.url(page)).then(this.refresh);
            },

            url(page = 1) {
                if (!page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }

                return `${location.pathname}?search=${this.search}&status=${this.status}&page=${page ?? null}&perpage=${this.perpage}`;
            },

            refresh({ data }) {
                this.dataSet = data;
                this.items = data.data;

                window.scrollTo(0, 0);
            }
        }
    }
</script>
