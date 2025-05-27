const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
//const markerAKM071 = require('../../svg/AKM071.svg');
import markerAKM071 from'../../svg/AKM071.svg';
import markerAKM072 from '../../svg/AKM072.svg';
import markerAKM073 from '../../svg/AKM073.svg';
import markerDEFAULT from '../../svg/DEFAULT.svg';

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
		},
	  	apIconById: (state) => (id) => {
			if (state.all.length) {
				let result = state.all.find(el => el.id === id);
				let apMac = typeof(result) === 'undefined' ? {} : result.ap_mac;
				let markerIcon;
				switch (apMac) {
				  case '00:27:22:12:DF:EE':
				    markerIcon = markerAKM071;
				    break;
				  case '00:27:22:12:DF:7F':
				    markerIcon = markerAKM072;
				    break;
				  case 'DC:9F:DB:34:13:4D':
				    markerIcon = markerAKM073;
				    break;
				  default:
				    markerIcon = markerDEFAULT;
				}
				return markerIcon;
			}
			return markerDEFAULT;
		}
	}
}