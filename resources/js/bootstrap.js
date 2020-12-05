window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.defaults.withCredentials = true;

try {
    window.Popper = require('popper.js').default;

    require('bootstrap');
} catch(e) {
    console.log(e);
}
