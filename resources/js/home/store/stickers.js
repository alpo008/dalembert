export default {
	state : {
    active: [],
    ticker: null,
    topPriority: [],
    mediumPriority: [],
    lowPriority: []
	},
	mutations : {
    setStickers(state, payload) {
      state.active = payload;
      state.topPriority = _.filter(payload, ['priority', 1]);
      state.mediumPriority = _.filter(payload, ['priority', 2]);
      state.lowPriority = _.filter(payload, ['priority', 3]);
    }
	},
	actions : {
    async updateStickers({ commit, getters }) {
      let response = await axios.post('/home/globus');
      commit('setStickers', getters.findOrFail(response, 'data.active_stickers'));
    }
	},
	getters: {
    activeStickers(state) {
      return state.active;
    },
    sortedStickers(state) {
      return {
        'top' : state.topPriority,
        'medium' : state.mediumPriority,
        'low' : state.lowPriority
      }
    }
	}
}