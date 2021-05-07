<template>
    <div v-if="links.length > 3" class="mt-12 mb-6 flex items-center justify-between">
        <div class="flex-1 flex items-center justify-center">
            <div>
                <nav class="relative z-0 inline-flex rounded-lg shadow-sm -space-x-px border-t border-b border-gray-200 overflow-hidden" aria-label="Pagination">
                    <template v-for="(link, key) in links" :key="key">
                        <span  v-if="link.url === null" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 border-l border-r border-gray-200">
                            <span>
                                <span class="text-gray-600" v-if="link.label.includes('Previous')">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="text-gray-600" v-else-if="link.label.includes('Next')">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="text-gray-600" v-else v-html="link.label"></span>
                            </span>
                        </span>
                        <app-link v-else :href="link.url" class="relative inline-flex items-center px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 border-r border-l border-gray-200" :class="{ 'bg-gray-50': link.active }">
                            <span>
                                <span class="text-gray-600" v-if="link.label.includes('Previous')">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="text-gray-600" v-else-if="link.label.includes('Next')">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <span class="text-gray-600" v-else v-html="link.label"></span>
                            </span>
                        </app-link>
                    </template>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
import AppLink from '@/Views/Components/Base/Link';

export default {
    components: {
        AppLink
    },

    props: {
        links: Array,
    },
}
</script>
