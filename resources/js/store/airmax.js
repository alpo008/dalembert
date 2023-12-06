export default {
	state : {
		    all: [],
		    currentClient: {},
		    place: ''
		},
	mutations : {
		setClients(state, payload) {
			if(typeof(payload.clients) === 'object') {
				state.all = payload.clients;
			}		
		},
		setCurrentClient(state, payload) {
			state.place = payload;
			if(!state.all.length) {

			}
		}
	},
	actions: {
		updateAirmaxClients(context, payload) {
        	return context.dispatch('httpRequest', {
              url: '/airmax-clients',
              method: 'GET',
              data: null,
              mutation: 'setClients'
            });
		},
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