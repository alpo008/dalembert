const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {}
		},
	mutations : {
		setCurrentDevice(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
				state.all = state.all.filter(el => el.id !== payload.current.id);
				state.all.push(state.current);
			}		
		},
		setDevices(state, payload) {
			if(typeof(payload.logs) === 'object') {
				state.all = payload.logs;
			}
		},
		afterDeleteDevice(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		},
		setMediaContents(state, payload) {
			state.fileContents = payload.contents;
		},
	},
	actions: {
	},
	getters: {
		currentDevice(state) {
			return state.current;
		},
		allDevices(state) {
			return state.all;
		}
	}
}