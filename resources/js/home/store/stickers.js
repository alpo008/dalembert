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
      state.active = payload.active_stickers;
      state.topPriority = _.filter(payload.active_stickers, ['priority', 1]);
      state.mediumPriority = _.filter(payload.active_stickers, ['priority', 2]);
      state.lowPriority = _.filter(payload.active_stickers, ['priority', 3]);
    }
	},
	actions : {
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