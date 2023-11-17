import { createStore } from 'vuex';

import weather from './weather';
import airmax from './airmax';
import general from './general';

export const store = createStore({
/*  state () {
    return {
      count: 1
    }
  },*/
	modules: {
		weather,
    airmax,
    general
	}
})