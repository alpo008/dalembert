import * as VueRouter from 'vue-router';
import { createRouter, createWebHistory } from 'vue-router';

import AppHome from './components/AppHome.vue';
import AppMeteo from './components/AppMeteo.vue';
import AppWebcam from './components/AppWebcam.vue';
import AppSticker from './components/AppSticker.vue';

export default VueRouter.createRouter({
    routes: [
        {
            path: '/',
            name: 'Home',
            component: AppHome,
            meta: {
                searchBar: false
            }
        },
        {
            path: '/meteo',
            name: 'Meteo',
            component: AppMeteo,
            meta: {
                searchBar: false
            }
        },
        {
            path: '/webcam',
            name: 'Webcam',
            component: AppWebcam,
            meta: {
                searchBar: false
            }
        },
        {
            path: '/stickers/:id(\\d+)',
            name: 'Sticker',
            component: AppSticker,
            meta: {
                searchBar: false
            }
        },
    ],
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 };
    },
    history: createWebHistory(),
});