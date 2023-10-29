import * as VueRouter from 'vue-router';
import { createRouter, createWebHistory } from 'vue-router'

import AppHome from './components/AppHome.vue';
import AppDiagram from './components/AppDiagram.vue';
import AppDiagrams from './components/AppDiagrams.vue';
import AppAirmax from './components/AppAirmax.vue';

export default VueRouter.createRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: AppHome,
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
            path: '/Airmax',
            name: 'Airmax clients page',
            component: AppAirmax,
        },
    ],
    history: createWebHistory(),
});