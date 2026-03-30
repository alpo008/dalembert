const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    meteoMode: true
		},
	mutations : {
		setMeteoMode(state, payload) {
			state.meteoMode = payload;		
		}
	},
	actions: {
		clientDocuments(context, payload) {
        	//
		},
	},
	getters: {
		showStickers(state) {
			return !state.meteoMode;
		},
	}
}