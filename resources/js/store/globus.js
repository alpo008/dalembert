const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    stickersMode: true
		},
	mutations : {
		setStickersMode(state, payload) {
			state.stickersMode = payload;		
		}
	},
	actions: {
		clientDocuments(context, payload) {
        	//
		},
	},
	getters: {
		showStickers(state) {
			return state.stickersMode;
		},
	}
}