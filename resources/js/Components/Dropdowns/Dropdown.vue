<template>
    <div class="dropdown leading-none flex-no-shrink">
        <a href="#" class="flex-no-shrink block dropdown-toggle focus:outline-none transition ease-in-out duration-150" data-toggle="dropdown" aria-expanded="false" role="button">
            <slot name="trigger"></slot>
        </a>

        <div class="dropdown-menu dropdown-menu-right mt-2 border-none rounded-xl shadow-lg bg-white p-2">
            <slot name="items"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        //
    }
</script>
