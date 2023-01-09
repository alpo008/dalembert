import * as VueRouter from 'vue-router';
import { createRouter, createWebHistory } from 'vue-router'

/*let HistoryPage = require('./pages/History.vue');
let CardPage = require('./pages/Card.vue');
let PhotoBookPage = require('./pages/PhotoBook.vue');
let PhotoBookEditPage = require('./pages/PhotoBookEdit.vue');
let CalendarA3Page = require('./pages/CalendarA3.vue');
let CalendarDesktopPage = require('./pages/CalendarDesktop.vue');
let CalendarCirclePage = require('./pages/CalendarCircle.vue');
let OrdersPage = require('./pages/Orders.vue');
let NotFound = require('./pages/NotFound.vue');*/

//const routerPrefix = document.querySelector('html').lang == 'ru-RU' ? '/ru' : '/en';

import AppHome from './components/AppHome.vue';
import AppDiagram from './components/AppDiagram.vue';
import AppDiagrams from './components/AppDiagrams.vue';

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
    ],
    history: createWebHistory(),
});