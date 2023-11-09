export default {
	state : {
		    all: [],
		    currentClient: {},
		    place: ''
		},
	mutations : {
		setClients(state, payload) {
			state.all = payload;
		},
		setCurrentClient(state, payload) {
			state.place = payload;
			if(!state.all.length) {

			}

		}
	},
	actions: {
		updateAirmaxClients(context, payload) {
			let allClients = require('../../data/clients.json');  
			context.commit('setClients', allClients);
		}
	},
	getters: {
		airmaxClients(state) {
			return state.all;
		},
		currentAirmaxClient(state) {
			if (state.all.length) {
				return state.all.find(el => el.place === state.place);
			}
			return '';
		}
	}
}