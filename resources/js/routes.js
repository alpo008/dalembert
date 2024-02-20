import * as VueRouter from 'vue-router';
import { createRouter, createWebHistory } from 'vue-router'

import AppHome from './components/AppHome.vue';
import AppLogin from './components/AppLogin.vue';
import AppDiagram from './components/AppDiagram.vue';
import AppDiagrams from './components/AppDiagrams.vue';
import AppAirmax from './components/AppAirmax.vue';
import AppAirmaxClient from './components/AppAirmaxClient.vue';
import AppStatistics from './components/AppStatistics.vue';
import AppWorks from './components/AppWorks.vue';

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
            path: '/login',
            name: 'login',
            component: AppLogin,
            meta: {
                searchBar: false,
                menuItem: false
            }
        },
        {
            path: '/diagrams/:id(\\d+)',
            name: 'Diagram',
            component: AppDiagram,
            meta: {
                searchBar: false,
                menuItem: false
            }
        },
        {
            path: '/diagrams',
            name: 'Diagrams',
            component: AppDiagrams,
            meta: {
                searchBar: false,
                menuItem: false
            }
        },
        {
            path: '/airmax',
            name: 'Airmax clients',
            component: AppAirmax,
            meta: {
                auth: {
                    roles: ['super', 'admin'],
                    redirect: '/'
                },
                searchBar: true,
                menuItem: true
            }
        },
        {
            path: '/statistics',
            name: 'Statistics',
            component: AppStatistics,
            meta: {
                auth: {
                    roles: ['super', 'admin'],
                    redirect: '/'
                },
                searchBar: true,
                menuItem: true
            }
        },
        {
            path: '/airmax/:place',
            name: 'Airmax client page',
            component: AppAirmaxClient,
            meta: {
                auth: {
                    roles: ['super', 'admin'],
                    redirect: '/'
                },
                searchBar: false,
                menuItem: false
            }
        },
        {
            path: '/works',
            name: 'Price list',
            component: AppWorks,
            meta: {
                auth: {
                    roles: ['super'],
                    redirect: '/'
                },
                searchBar: true,
                menuItem: true
            }
        },
    ],
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 };
    },
    history: createWebHistory(),
});