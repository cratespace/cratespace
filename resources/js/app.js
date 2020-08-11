import VueApexCharts from 'vue-apexcharts'

window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    window.flatpickr = require("flatpickr");

    require('bootstrap');
} catch (e) {}


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Vue = require('vue');

window.flash = function(message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

Vue.config.productionTip = false;

Vue.use(VueApexCharts);

Vue.component('apexchart', VueApexCharts);
Vue.component('graph', require('./components/Graph.vue').default);
Vue.component("image-upload-form", require("./components/ImageUploadForm.vue").default);
Vue.component("flash", require("./components/Flash.vue").default);
Vue.component("checkout", require("./components/Checkout.vue").default);
Vue.component("uid-input", require("./components/UidInput.vue").default);

const app = new Vue({
    el: '#app',
});

flatpickr('.datepicker', {
    dateFormat: 'Y-m-d',
    altInput: true,
    altFormat: 'j M Y',
    ariaDateFormat: 'Y-m-d',
    enableTime: false
});

// window.addEventListener('contextmenu', function(e) {
//     e.preventDefault();
// }, false);
