import * as VueRouter from 'vue-router';
import { createRouter, createWebHistory } from 'vue-router'

import AppHome from './components/AppHome.vue';
import AppHomeMeteo from './components/AppHomeMeteo.vue';
import AppHomeWebcam from './components/AppHomeWebcam.vue';

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
            name: 'Meteo',
            component: AppHomeMeteo,
            meta: {
                searchBar: false,
                menuItem: false
            }
        },
        {
            path: '/webcam',
            name: 'Webcam',
            component: AppHomeWebcam,
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