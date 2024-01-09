const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {},
		    uploaded: {},
		    fileContents: ''
		},
	mutations : {
		setUploaded(state, payload) {
			if(typeof(payload.uploaded) === 'object') {
				state.uploaded = payload.uploaded;
			}		
		},
		setCurrentPayment(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
				state.all.push(state.current);
			}		
		},
		setPayments(state, payload) {
			if(typeof(payload.payments) === 'object') {
				state.all = payload.payments;
			}		
		},
		afterDeletePayment(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		},
		setMediaContents(state, payload) {
			state.fileContents = payload.contents;
		}
	},
	actions: {
		clientPayments(context, payload) {
        	//
		},
	},
	getters: {
		currentPayment(state) {
			return state.current;
		},
		allPayments(state) {
			return state.all;
		}
	}
}