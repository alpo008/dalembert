const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: []
		},
	mutations : {
		setWorks(state, payload) {
			if(typeof(payload.works) === 'object' && !isEmpty(payload.works)) {
				state.all = payload.works;
			}	
		}
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