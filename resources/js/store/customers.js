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
		}
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
	    customerById: (state) => (id) => {
	      return state.all.find(customer => customer.id === id)
	    }
	}
}