const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    place: '',
		    id: '',
		    current: {}
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
				state.current = payload.current;
				if (!isEmpty(payload.current)) {
					state.all.push(payload.current);
					state.id = payload.current.id;
				}
			} else {
				state.id = null;
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
			if (!isNaN(state.current.id)) {
				return state.current;
			}
			if (state.all.length) {
				let result = state.all.find(el => el.place === state.place);
				return typeof(result) === 'undefined' ? {} : result;
			}
			return {};
		},
		currentAirmaxClientId(state) {
			return state.id
		}
	}
}