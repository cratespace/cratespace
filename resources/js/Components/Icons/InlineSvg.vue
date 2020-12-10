<script>
    export default {
        props: ['name'],

        render(h) {
            const svg = require(`./svg/o-${this.name}.svg`);

            return h('div', {
                domProps: {
                    innerHTML: svg
                }
            });
        }
    }
</script>
