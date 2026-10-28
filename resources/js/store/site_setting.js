const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {}
		},
	mutations : {
		setCurrentSiteSetting(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
				state.all = state.all.filter((el) => (el.id !== payload.current.id));
				state.all.push(state.current);
			}		
		},
		setSiteSettings(state, payload) {
			if(typeof(payload.settings) === 'object') {
				state.all = payload.settings;
			}
		},
		afterDeleteSiteSetting(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		}
	},
	actions: {
	},
	getters: {
		currentSiteSetting(state) {
			return state.current;
		},
		allSiteSettings(state) {
			return state.all;
		}
	}
}