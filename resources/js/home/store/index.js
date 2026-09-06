import { createStore } from 'vuex';

import general from './general';
import stickers from './stickers';
import meteo from './meteo';

export const store = createStore({
	modules: {
        general,
        stickers,
        meteo
	}
})