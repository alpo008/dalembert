const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {},
		    uploaded: {},
		    fileContents: '',
		    active_stickers: [],
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
				state.all = state.all.filter(el => el.id !== payload.current.id);
				state.all.push(state.current);
			}		
		},
		setStickers(state, payload) {
			if(typeof(payload.stickers) === 'object') {
				state.all = payload.stickers;
			}
			if(typeof(payload.active_stickers) === 'object') {
				state.active_stickers = payload.active_stickers;
			}		
		},
		afterDeleteSticker(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		},
		setMediaContents(state, payload) {
			console.log(payload);
			state.fileContents = payload.contents;
		},
	},
	actions: {
	},
	getters: {
		currentSticker(state) {
			return state.current;
		},
		allStickers(state) {
			return state.all;
		},
		activeStickers(state) {
			return state.active_stickers;
		},
		stickerMediaContents(state) {
			return state.fileContents;
		}
	}
}