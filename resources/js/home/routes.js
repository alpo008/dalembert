import * as VueRouter from 'vue-router';
import { createRouter, createWebHistory } from 'vue-router';

import AppHome from './components/AppHome.vue';
import AppMeteo from './components/AppMeteo.vue';
import AppWebcam from './components/AppWebcam.vue';

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
            component: AppMeteo,
            meta: {
                searchBar: false,
                menuItem: false
            }
        },
        {
            path: '/webcam',
            name: 'Webcam',
            component: AppWebcam,
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