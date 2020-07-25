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

Vue.config.productionTip = false;

Vue.use(VueApexCharts);

Vue.component('apexchart', VueApexCharts);
Vue.component('graph', require('./components/Graph.vue').default);

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
