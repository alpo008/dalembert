export default {
	state : {
		    all: [],
		    place: ''
		},
	mutations : {
		setClients(state, payload) {
			if(typeof(payload.clients) === 'object') {
				state.all = payload.clients;
			}		
		},
		setCurrentPlace(state, payload) {
			if(typeof(payload) === 'string') {
				state.place = payload;
			}
		},
		setCurrentClient(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.all.push(payload.current);
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
				let result = state.all.find(el => el.place === state.place);
				return typeof(result) === 'undefined' ? {} : result;
			}
			return {};
		}
	}
}