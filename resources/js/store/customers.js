const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {}
		},
	mutations : {
		setCustomers(state, payload) {
			if(typeof(payload.customers) === 'object' && !isEmpty(payload.customers)) {
				state.all = payload.customers;
			}	
		},
		setCurrentCustomer(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
				state.all = state.all.filter(el => el.id !== payload.current.id);
				state.all.push(state.current);
			}		
		},
		afterDeleteCustomer(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		},
	},
	actions: {
		newAction(context, payload) {
        	//
		},
	},
	getters: {
		allCustomers(state) {
			return state.all;
		},
		currentCustomer(state) {
			return state.current;
		},
	    customerById: (state) => (id) => {
	      return state.all.find(customer => customer.id === id);
	    }
	}
}