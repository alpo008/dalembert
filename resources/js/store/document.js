const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {},
		    fileContents: ''
		},
	mutations : {
		setCurrentDocument(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
				state.all.push(state.current);
			}		
		},
		setAttachments(state, payload) {
			if(typeof(payload.attachments) === 'object') {
				state.all = payload.attachments;
			}		
		},
		afterDeleteAttachment(state, payload) {
			state.all = state.all.filter(el => el.id !== payload.deleted);
		},
		setMediaContents(state, payload) {
			state.fileContents = payload.contents;
		}
	},
	actions: {
		clientDocuments(context, payload) {
        	//
		},
	},
	getters: {
		currentDocument(state) {
			return state.current;
		},
		allAttachments(state) {
			return state.all;
		},
		fileContents(state) {
			return state.fileContents;
		}
	}
}