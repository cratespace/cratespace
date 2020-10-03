export default {
    data() {
        return {
            loading: false
        }
    },

    methods: {
        async update(route, form) {
            this.loading = true;

            await form.put(route).then(response => response.data.status);

            this.loading = false;
        }
    }
}
