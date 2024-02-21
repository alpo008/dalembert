const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {}
		},
	mutations : {
		setWorks(state, payload) {
			if(typeof(payload.works) === 'object' && !isEmpty(payload.works)) {
				state.all = payload.works;
			}	
		},
		setCurrentWork(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
				state.all = state.all.filter(el => el.id !== payload.current.id);
				state.all.push(state.current);
			}		
		},
		afterDeleteWork(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		},
	},
	actions: {
		newAction(context, payload) {
        	//
		},
	},
	getters: {
		allWorks(state) {
			return state.all;
		},
	}
}