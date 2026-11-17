import { createStore } from 'vuex';

import general from './general';
import stickers from './stickers';
import meteo from './meteo';
import hydrometry from './hydrometry';

export const store = createStore({
	modules: {
        general,
        stickers,
        meteo,
        hydrometry
	}
})