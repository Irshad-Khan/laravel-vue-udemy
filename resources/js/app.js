require('./bootstrap');
import VueRouter from 'vue-router';
import router from './routes';
import Index from './Index';
import moment from "moment";
import StarRating from './shared/components/StarRating';
import Vue from 'vue';

window.Vue = require('vue').default;
Vue.use(VueRouter);
Vue.component('StarRating', StarRating);
Vue.filter('fromNow', value => moment(value).fromNow());
const app = new Vue({
    el: '#app',
    router,
    components: {
        'index': Index
    }
});