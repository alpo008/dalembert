import { createStore } from 'vuex';

import general from './general';
import stickers from './stickers';

export const store = createStore({
	modules: {
        general,
        stickers
	}
})