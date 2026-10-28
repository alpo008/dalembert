import { createStore } from 'vuex';

import weather from './weather';
import airmax from './airmax';
import document from './document';
import payment from './payment';
import statistics from './statistics';
import works from './works';
import customers from './customers';
import general from './general';
import sticker from './sticker';
import globus from './globus';
import device from './device';
import app_registration from './app_registration';
import site_setting from './site_setting';

export const store = createStore({
	modules: {
    	weather,
        airmax,
        document,
        payment,
        statistics,
        works,
        customers,
        general,
        sticker,
        globus,
        device,
        app_registration,
        site_setting
	}
})