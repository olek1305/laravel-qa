require('./bootstrap');
require('./fontawesome');

window.Vue = require('vue');

import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.min.css';
import Authorization from './authorization/authorize';
import Preview from './components/Preview.vue';

Vue.use(VueIziToast);
Vue.use(Authorization);
Vue.use(Preview);

Vue.component('question-page', require('./pages/QuestionPage.vue').default);

const app = new Vue({
    el: '#app',
});
