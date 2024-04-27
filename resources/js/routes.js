import * as VueRouter from 'vue-router';
import { createRouter, createWebHistory } from 'vue-router'

import AppHome from './components/AppHome.vue';
import AppLogin from './components/AppLogin.vue';
import AppCustomer from './components/AppCustomer.vue';
import AppCustomers from './components/AppCustomers.vue';
import AppAirmax from './components/AppAirmax.vue';
import AppAirmaxClient from './components/AppAirmaxClient.vue';
import AppStatistics from './components/AppStatistics.vue';
import AppCalculator from './components/AppCalculator.vue';
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
            path: '/customers/:id(\\d+)',
            name: 'Customer',
            component: AppCustomer,
            meta: {
                auth: {
                    roles: ['super'],
                    redirect: '/'
                },
                searchBar: false,
                menuItem: false,
                showEditorButton: true
            }
        },
        {
            path: '/customers',
            name: 'Customers',
            component: AppCustomers,
            meta: {
                auth: {
                    roles: ['super'],
                    redirect: '/'
                },
                searchBar: true,
                menuItem: true
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
                menuItem: false,
                showEditorButton: true
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
        {
            path: '/calculator',
            name: 'Price calculator',
            component: AppCalculator,
            meta: {
                auth: {
                    roles: ['super', 'admin'],
                    redirect: '/'
                },
                searchBar: false,
                menuItem: true
            }
        },
    ],
    scrollBehavior(to, from, savedPosition) {
        return { top: 0 };
    },
    history: createWebHistory(),
});