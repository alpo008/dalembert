const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {}
		},
	mutations : {
		setHydrometry(state, payload) {
			if(typeof(payload.hydrometries) === 'object' && !isEmpty(payload.hydrometries)) {
				state.all = payload.hydrometries;
			}	
		},
		afterDeleteHydrometry(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		},
	},
	actions: {
		newAction(context, payload) {
        	//
		},
	},
	getters: {
		allHydrometry(state) {
			return state.all;
		},
		currentHydrometry(state) {
			return state.current;
		},
	    hydrometryByDate: (state) => (id) => {
	    }
	}
}