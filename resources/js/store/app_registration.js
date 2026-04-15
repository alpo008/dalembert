const isEmpty = obj => [Object, Appay].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {},
		},
	mutations : {
		setCurrentAppRegistration(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
				state.all.push(state.current);
			}
		},
		setAppRegistrations(state, payload) {
			if(typeof(payload.registrations) === 'object') {
				state.all = payload.registrations;
			}		
		},
		afterDeleteAppRegistration(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		},
	},
	actions: {
	},
	getters: {
		currentAppRegistration(state) {
			return state.current;
		},
		allAppRegistrations(state) {
			return state.all;
		}
	}
}