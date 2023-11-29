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
		    return axios.get('/airmax-clients')
	        .then(response => {
	            context.commit('setClients', response.data.clients);
	        }).catch(err => {
		        console.error(err);
		    });
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