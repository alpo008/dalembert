export default {
	state : {
    ticker: null,
	},
	mutations : {
    setWeatherTicker(state, payload) {
      state.ticker = payload.description;
    }
	},
	actions : {
	},
	getters: {
    weatherTicker(state) {
      return state.ticker;
    },
	}
}