export default {
    methods: {
        format(date) {
            return moment(date).format('MMMM Do YYYY, h:mm a');
        },

        diffForHumans(date) {
            return moment(date).fromNow();
        }
    }
}
