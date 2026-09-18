
export default {
	state : {
    current: null,
    history: null,
    ticker: null,
    updatedAt: null,
	},
	mutations : {
    setWeatherTicker(state, payload) {
      state.ticker = payload.description;
    },
    setWeatherData(state, payload) {
      state.current = this.getters.findOrFail(payload, 'all.data');
      state.history = this.getters.findOrFail(payload, 'history.data');
      state.updatedAt = Date.now();
    }
	},
	actions : {
	},
	getters: {
    weatherTicker(state) {
      return state.ticker;
    },
    currentWeather(state) {
      return state.current;
    },
    weatherHistory(state) {
      return state.current;
    },
    weatherUpdatedAt(state) {
      return state.updatedAt;
    }
  }
}