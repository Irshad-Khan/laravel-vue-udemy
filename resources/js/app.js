require('./bootstrap');
import VueRouter from 'vue-router';
import router from './routes';
import Index from './Index';
import moment from "moment";
import FatalError from './shared/FatalError';
import StarRating from './shared/components/StarRating';
import ValidationErrors from './shared/components/ValidationErrors';
import Vue from 'vue';

window.Vue = require('vue').default;
Vue.use(VueRouter);
Vue.component('StarRating', StarRating);
Vue.component('FatalError', FatalError);
Vue.component('ValidationError', ValidationErrors);

Vue.filter('fromNow', value => moment(value).fromNow());
const app = new Vue({
    el: '#app',
    router,
    components: {
        'index': Index
    }
});