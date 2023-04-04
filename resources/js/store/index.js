import { createStore } from 'vuex';

import weather from './weather';

export const store = createStore({
/*  state () {
    return {
      count: 1
    }
  },*/
	modules: {
		weather
	}
})