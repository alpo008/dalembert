/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import * as Vue from 'vue';

// Router
import * as VueRouter from 'vue-router';
import router from './routes.js';

// Axios
import axios from 'axios';
import VueAxios from 'vue-axios';
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`;

//import * as VueI18n from 'vue-i18n';
import { createI18n } from 'vue-i18n'
const messagesEn = require('../lang/en.json');
const messagesRu = require('../lang/ru.json');
const currentLocale = document.querySelector('html').getAttribute('lang');
const i18n = createI18n({
  locale: currentLocale,
  messages: {
    en: messagesEn,
    ru: messagesRu
  }
});

//  VueX
import { store } from './store';

//  App
import App from './components/App.vue';

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
})

Vue.createApp(App)
    .use(router)
    .use(vuetify)
    .use(VueAxios, axios)
    .use(i18n)
    .use(store)
    .mount('#app');