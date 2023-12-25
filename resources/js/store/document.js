const isEmpty = obj => [Object, Array].includes((obj || {}).constructor) && !Object.entries((obj || {})).length;
export default {
	state : {
		    all: [],
		    current: {},
		    uploaded: {}
		},
	mutations : {
		setUploaded(state, payload) {
			if(typeof(payload.uploaded) === 'object') {
				state.uploaded = payload.uploaded;
			}		
		},
		setCurrentDocument(state, payload) {
			if(typeof(payload.current) === 'object') {
				state.current = payload.current;
			}		
		},
		setAttachments(state, payload) {
			if(typeof(payload.attachments) === 'object') {
				state.all = payload.attachments;
			}		
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
		}
	}
}