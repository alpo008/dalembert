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
			console.log('updating')
		    return axios.get('/airmax-clients')
	        .then(response => {
	            context.commit('setClients', response.data.clients);
	        }).catch(err => {
		        context.commit('updateErrors', err);
		    });
		},
		saveClient(context, payload) {
			if (!isNaN(payload.id)) {
				return axios.put('/airmax-clients/' + payload.id, payload)
		        .then(response => {
		            console.log(response);
		        }).catch(err => {
			        context.commit('updateErrors', err);
			    });	
			}
			return axios.post('/airmax-clients', payload)
	        .then(response => {
	            console.log(response);
	        }).catch(err => {
		        context.commit('updateErrors', err);
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