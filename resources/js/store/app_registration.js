const isEmpty = obj => [Object, Appay].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {},
		    key: '',
		    new: false
		},
	mutations : {
		setCurrentAppRegistration(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
				state.all.push(state.current);
			}
			if(typeof(payload.key) === 'string') {
				state.key = payload.key;
			}
			if(typeof(payload.new) === 'boolean') {
				state.new = payload.new;
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
		},
		currentAppRegistrationKey(state) {
			return state.key;
		},
		isNewAppRegistrationKey(state) {
			return state.new;
		}
	}
}