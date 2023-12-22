require('./bootstrap');
require('./fontawesome');

window.Vue = require('vue');

import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.min.css';
import Authorization from './authorization/authorize';
import router from './router';
import Spinner from './components/Spinner.vue'

Vue.use(VueIziToast);
Vue.use(Authorization);

Vue.component('spinner', Spinner)

const app = new Vue({
    el: '#app',

    data: {
        loading: false
    },

    created () {
        // Add a request interceptor
        axios.interceptors.request.use((config) => {
            this.loading = true;
            return config;
        }, (error) => {
            this.loading = false
            return Promise.reject(error);
        });

        // Add a response interceptor
        axios.interceptors.response.use((response) => {
            this.loading = false;
            return response;
        }, (error) =>  {
            this.loading = false
            return Promise.reject(error);
        });
    },

    router
});
