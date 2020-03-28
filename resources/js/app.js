require('./bootstrap');

import VueApexCharts from 'vue-apexcharts'

window.Vue = require('vue');

Vue.config.productionTip = false;

Vue.use(VueApexCharts);

window.events = new Vue();

window.flash = function(message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

Vue.component('apexchart', VueApexCharts);
Vue.component("image-upload-form", require("./components/ImageUploadForm.vue").default);
Vue.component("flash", require("./components/Flash.vue").default);
Vue.component("order", require("./components/Orders/Order.vue").default);
Vue.component("graph", require("./components/Graph.vue").default);

// Spaces
// Vue.component("spaces", require("./components/Spaces/List.vue").default);

const app = new Vue({
    el: '#app',
});
