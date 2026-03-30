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
    globus
	}
})