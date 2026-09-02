import { createStore } from 'vuex';

import general from './general';

export const store = createStore({
	modules: {
        general
	}
})