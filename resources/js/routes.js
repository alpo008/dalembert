import * as VueRouter from 'vue-router';
import { createRouter, createWebHistory } from 'vue-router'

import AppHome from './components/AppHome.vue';
import AppLogin from './components/AppLogin.vue';
import AppDiagram from './components/AppDiagram.vue';
import AppDiagrams from './components/AppDiagrams.vue';
import AppAirmax from './components/AppAirmax.vue';
import AppAirmaxClient from './components/AppAirmaxClient.vue';

export default VueRouter.createRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: AppHome,
        },
        {
            path: '/login',
            name: 'login',
            component: AppLogin,
        },
        {
            path: '/diagrams/:id(\\d+)',
            name: 'Diagram page',
            component: AppDiagram,
        },
        {
            path: '/diagrams',
            name: 'Diagrams page',
            component: AppDiagrams,
        },
        {
            path: '/airmax',
            name: 'Airmax clients page',
            component: AppAirmax,
        },
        {
            path: '/airmax/:place',
            name: 'Airmax client page',
            component: AppAirmaxClient,
        },
    ],
    history: createWebHistory(),
});