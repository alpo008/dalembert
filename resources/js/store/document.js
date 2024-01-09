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
			state.uploaded = {};
			if(typeof(payload.uploaded) === 'object') {
				state.uploaded = payload.uploaded;
			}		
		},
		setCurrentDocument(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
				state.current.media ??= state.uploaded;
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
		uploadedFile(state) {
			return state.uploaded;
		},
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