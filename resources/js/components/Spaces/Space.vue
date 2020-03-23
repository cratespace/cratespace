<template>
    <div class="bg-white px-4 py-5 sm:px-6 border-b border-gray-300">
        <div class="row items-start">
            <div class="col-md-4">
                <div class="flex justify-between">
                    <div>
                        <div>
                            <div class="font-bold text-gray-600 uppercase mb-2">{{ '#' + space.uid }}</div>

                            <span class="relative inline-block px-3 py-1 text-xs font-semibold text-indigo-800 leading-tight">
                                <span aria-hidden="" class="absolute inset-0 bg-indigo-200 opacity-50 rounded-full"></span>
                                <span class="relative">{{ space.ships_to }}</span>
                            </span>
                        </div>

                        <div class="mt-2">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z"/>
                                    <path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z"/>
                                </svg>

                                <span class="text-xs text-gray-600">Dimensions</span>
                            </div>

                            <div class="flex text-xl">
                                <div class="mr-3">
                                    {{ space.height }} <span class="text-sm text-gray-600">Ft</span>
                                </div>

                                <div class="mr-3">
                                    {{ space.width }} <span class="text-sm text-gray-600">Ft</span>
                                </div>

                                <div>
                                    {{ space.length }} <span class="text-sm text-gray-600">Ft</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-2">
                            <div class="text-xl">
                                {{ '$' + space.price }} <span class="text-sm text-gray-600">USD</span>
                            </div>
                        </div>
                    </div>

                    <div class="block md:hidden text-right">
                        <span class="text-4xl font-thin leading-none">{{ '$' + space.price }}</span>

                        <div class="text-xs text-gray-600 font-medium">USD</div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-4 md:mt-0">
                <div>
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd"/>
                        </svg>

                        <span class="text-xs text-gray-600">M.A.W</span>
                    </div>

                    <div class="text-xl">
                        {{ space.weight }} <span class="text-sm text-gray-600">Kg</span>
                    </div>
                </div>

                <div class="mt-2">
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>

                        <div class="text-xs text-gray-600">Origin</div>
                    </div>

                    <div>{{ space.origin }}</div>
                </div>

                <div class="mt-2">
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>

                        <div class="text-xs text-gray-600">Destination</div>
                    </div>

                    <div>{{ space.destination }}</div>
                </div>
            </div>

            <div class="col-md-4 mt-4 md:mt-0">
                <div class="flex justify-between items-end md:items-start">
                    <div>
                        <div class="text-sm mb-4">
                            <div>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>

                                    <div class="text-xs text-gray-600">Departs</div>
                                </div>
                                <div class="text-indigo-500 font-medium">{{ format(space.departs_at) }}</div>
                            </div>

                            <div class="text-xs text-gray-600">
                                {{ diffForHumans(space.departs_at) }}
                            </div>
                        </div>

                        <div class="text-sm">
                            <div>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>

                                    <div class="text-xs text-gray-600">Arrives</div>
                                </div>
                                <div class="text-indigo-500 font-medium">{{ format(space.arrives_at) }}</div>
                            </div>

                            <div class="text-xs text-gray-600">
                                {{ diffForHumans(space.arrives_at) }}
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="dropdown ml-auto">
                            <button class="dropdown-toggle focus:outline-none" id="userDropDown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg class="h-6 w-6 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                                </svg>
                            </button>

                            <div class="dropdown-menu dropdown-menu-right rounded-lg shadow-lg z-50 mt-3" aria-labelledby="userDropDown">
                                <a :href="space.path" class="dropdown-item block px-4 py-2 text-sm">View</a>
                                <a :href="space.path + '/edit'" class="dropdown-item block px-4 py-2 text-sm">Edit</a>
                                <a href="#" class="dropdown-item block px-4 py-2 text-sm text-red-500 hover:text-red-500 focus:text-white" data-toggle="modal" :data-target="'#delete' + space.uid">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <delete-confirmation :space="space" @deleted="destroy"></delete-confirmation>
    </div>
</template>

<script>
    import DeleteConfirmation from './DeleteConfirmation';

    export default {
        components: { DeleteConfirmation },

        props: ['space'],

        methods: {
            destroy() {
                location.reload();
            },

            format(date) {
                return moment(date).format('MMMM Do YYYY, h:mm a');
            },

            diffForHumans(date) {
                return moment(date).fromNow();
            }
        }
    }
</script>
