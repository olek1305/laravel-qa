require('./bootstrap');
require('./fontawesome');

window.Vue = require('vue');

import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.min.css';
import Authorization from './authorization/authorize';
import router from './router';

Vue.use(VueIziToast);
Vue.use(Authorization);

Vue.component('question-page', require('./pages/QuestionPage.vue').default);

const app = new Vue({
    el: '#app',
    router
});
