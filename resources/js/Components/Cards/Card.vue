<template>
    <div class="shadow overflow-hidden sm:rounded-xl">
        <div class="px-4 py-5 bg-white sm:px-6">
            <slot name="content"></slot>
        </div>

        <div class="flex items-center justify-end px-4 py-5 bg-gray-100 text-right sm:px-6">
            <slot name="actions"></slot>
        </div>
    </div>
</template>

