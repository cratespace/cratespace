import VueApexCharts from 'vue-apexcharts';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.flatpickr = require("flatpickr");

    require('bootstrap');
} catch (e) {}

// window.addEventListener('contextmenu', function(e) {
//     e.preventDefault();
// }, false);

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '1b4599a5ad1bd431131c',
    cluster: 'us2',
    forceTLS: true,
    encrypted: true
});

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Vue = require('vue');

window.flash = function(message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

Vue.config.productionTip = false;

Vue.use(VueApexCharts);

// User Settings Components
Vue.component("profile", require("./components/settings/Profile.vue").default);
Vue.component("business", require("./components/settings/Business.vue").default);

Vue.component('apexchart', VueApexCharts);
Vue.component('graph', require('./components/Graph.vue').default);
Vue.component("image-upload-form", require("./components/ImageUploadForm.vue").default);
Vue.component("flash", require("./components/Flash.vue").default);
Vue.component("checkout", require("./components/Checkout.vue").default);
Vue.component("hashids-input", require("./components/HashIdsInput.vue").default);
Vue.component("order-status", require("./components/OrderStatus.vue").default);
Vue.component("order-update-status", require("./components/OrderUpdateStatus.vue").default);

const app = new Vue({
    el: '#app',
});
