import VueRouter from 'vue-router';
import Home from './Home';
import Bookables from './bookables/Bookables';
import Bookable from './bookables/Bookable';

const routes = [{
        path: '/',
        component: Home,
        name: 'home'
    },
    {
        path: '/bookables',
        component: Bookables,
        name: 'bookables'
    },
    {
        path: '/bookable/:id',
        component: Bookable,
        name: 'bookable'
    }
];

const router = new VueRouter({
    routes,
    mode: 'history',
    linkExactActiveClass: "active",
});

export default router;