<template>
    <button type="submit" v-if="as == 'button'" class="dropdown-item rounded-lg leading-6 block text-gray-600 hover:text-gray-600 focus:text-white focus:text-white hover:bg-gray-100 focus:bg-blue-500 active:bg-blue-600 focus:outline-none transition ease-in-out duration-150">
        <span class="font-semibold text-sm"><slot></slot></span>
    </button>

    <a v-else class="dropdown-item rounded-lg leading-6 block text-gray-600 hover:text-gray-600 focus:text-white focus:text-white hover:bg-gray-100 focus:bg-blue-500 active:bg-blue-600 focus:outline-none transition ease-in-out duration-150" href="#">
        <span class="font-semibold text-sm"><slot></slot></span>
    </a>
</template>

<script>
    export default {
        props: ['as']
    }
</script>
