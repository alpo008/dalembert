import * as VueRouter from 'vue-router';
import { createRouter, createWebHistory } from 'vue-router'

import AppHome from './components/AppHome.vue';
import AppHomeMeteo from './components/AppHomeMeteo.vue';

export default VueRouter.createRouter({
    routes: [
        {
            path: '/',
            name: 'Home',
            component: AppHome,
            meta: {
                searchBar: false,
                menuItem: true
            }
        },
        {
            path: '/meteo',
            name: 'meteo',
            component: AppHomeMeteo,
            meta: {
                searchBar: false,
                menuItem: false
            }
        },
    ],
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 };
    },
    history: createWebHistory(),
});