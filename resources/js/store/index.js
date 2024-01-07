import { createStore } from 'vuex';

import weather from './weather';
import airmax from './airmax';
import document from './document';
import payment from './payment';
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
    document,
    payment,
    general
	}
})