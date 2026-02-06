const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {},
		    uploaded: {},
		    fileContents: ''
		},
	mutations : {
		setUploaded(state, payload) {
			if(typeof(payload.uploaded) === 'object') {
				state.uploaded = payload.uploaded;
			}		
		},
		setCurrentSticker(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
				state.all.push(state.current);
			}		
		},
		setStickers(state, payload) {
			if(typeof(payload.stickers) === 'object') {
				state.all = payload.stickers;
			}		
		},
		afterDeleteSticker(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		},
		setMediaContents(state, payload) {
			state.fileContents = payload.contents;
		}
	},
	actions: {
	},
	getters: {
		currentSticker(state) {
			return state.current;
		},
		allStickers(state) {
			return state.all;
		}
	}
}