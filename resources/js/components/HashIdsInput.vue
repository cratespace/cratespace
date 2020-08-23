<template>
    <label class="block">
        <span class="text-gray-700 text-sm font-semibold">Unique Identification Code</span>

        <input type="text" name="code" id="code" class="form-input mt-1 block w-full" placeholder="WA52M" required v-model="code">

        <div class="mt-1 text-xs">
            <span>This will be used to index and identify the space. You can also generate a unique ID using our generator.</span>
            <a href="#" role="button" @click="generateHashId()">Generate HashedID</a>
        </div>
    </label>
</template>

<script>
    import Hashids from 'hashids';

    export default {
        props: ['code'],

        data() {
            return {
                hashids: new Hashids()
            }
        },

        methods: {
            generateHashId() {
                this.code = 'SP' + this.hashids.encode(Date.now()).toUpperCase();
            }
        }
    }
</script>
