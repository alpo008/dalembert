export default {
	state : {
		    all: []
		},
	mutations : {
		setClients(state, payload) {
			state.all = payload;
		}
	},
	actions: {
		updateAirmaxClients(context, payload) {
			let allClients = require('../../data/clients.json');  
			context.commit('setClients', allClients);
		},
	},
	getters: {
		airmaxClients(state) {
			return state.all;
		}
	}
}